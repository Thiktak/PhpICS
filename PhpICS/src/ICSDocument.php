<?php

Class ICSDocument extends ICSObjects {
  protected $content;
  protected $filename;

  protected $children = array();
  protected $parsers = array('ICSVEvent');

  public function __construct($content, $filename = null) {
    $this->content = $content;
    $this->filename = $filename;
  }

  public static function load($content) {
    if( file_exists($content) )
      $content = file_get_contents($content);
    
    $doc = new self($content, func_get_args(1));
    $doc -> parse();
    return $doc;
  }

  public static function parseObject(ICSDocument $doc, $content) {
  }

  public function saveObject() {
    $return = array();

    $return[] = 'BEGIN:VCALENDAR';
    $return[] = 'VERSION:2.0';
    $return[] = 'CALSCALE:GREGORIAN';

    foreach( $this->children as $event ) {
      $return[] = $event->save();
    }

    $return[] = 'END:VCALENDAR';

    return implode(PHP_EOL, $return);
  }

  public function save($filename = null) {
    if( $filename === true )
      $filename = $this->filename;

    return parent::save($filename);
  }
}