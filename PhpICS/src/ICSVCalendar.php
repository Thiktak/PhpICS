<?php

/**
 * ICSVDocument
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
Class ICSVCalendar extends ICSObjects {

  protected $children = array();
  protected $parsers = array('ICSVEvent');

  protected $version;

  public function getVersion() {
    return $this->version;
  }
  public function setVersion($version) {
    $this->version = $version;
    return $this;
  }

  public function getDatas() {
    // @TODO find simple $this[protected:] export
    return array(
      'version' => $this->version,
    );
  }

  public static function parseObject(ICSObjects $doc, $content) {
    return preg_replace_callback('`[[:space:]]*BEGIN:VCALENDAR(.*)END:VCALENDAR`sUi', function($matche) use(&$doc) {
    
        // VEvent parser

        $event = new ICSVEvent();
        preg_replace_callback('`^[[:blank:]]*([A-Z]+):(.*)$`miU', function($m2) use(&$doc, $event) {
          $m2[2] = trim($m2[2]);
          $event->$m2[1] = $m2[2];
        }, $matche[1]);
        $doc->addChildren($event);
        return null;
        
        // /VEvent

    }, $content);
  }

  public function saveObject() {
    $return = array();

    $return[] = 'BEGIN:VCALENDAR';

    foreach( $this->getDatas() as $name => $value ) {
      if( $value !== null )
        $return[] = strtoupper($name) . ':' . $value;
    }

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