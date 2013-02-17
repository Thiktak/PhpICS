<?php

/**
 * ICS
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
Class ICS extends ICSObjects {
  protected $filename;

  protected $document;

  protected $children = array();
  protected $parsers = array('ICSVCalendar');

  public function __construct($content, $filename = null) {
    $this->filename = $filename;
    $this->content = $content;
  }

  public static function load($content, $filename = null) {
    $doc = new self($content, $filename);
    $doc -> parse();
    return $doc;
  }

  public static function open($filename) {
    $content = file_get_contents($filename);
    return self::load($content, $filename);
  }

  public function getIterator() {
    if( $this->children )
      return current($this->children)->getIterator();
    return new ArrayIterator();
  }
  
  public function getCalendar() {
    if( $this->children )
      return current($this->children);
    return null;
  }

  public static function parseObject(ICSObjects $doc, $content) {
  }

  public function saveObject() {
    $return = '';

    foreach( $this->getChildren() as $event ) {
      $return .= $event->save() . PHP_EOL;
    }
    return $return;
  }
}