<?php

namespace ICS\Element;
use ICS\Objects;

/**
 * ICSVDocument
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
Class Calendar extends Objects {

  protected $children = array();
  protected $parsers = array('Event', 'Todo', 'Journal');

  protected $version;
  protected $prodid;
  protected $method;
  protected $calscale;

  public function setName($name) {
      $extended["X-WR-CALNAME"] = $name;
  }

  public function setTimezone($value) {
      $extended["X-WR-TIMEZONE"] = $value;
  }

  public function getVersion() {
    return $this->version;
  }
  public function setVersion($version) {
    $this->version = $version;
    return $this;
  }

  public function getMethod() {
    return $this->method;
  }
  public function setMethod($method) {
    $this->method = $method;
    return $this;
  }

  public function getCalscale() {
    return $this->calscale;
  }
  public function setCalscale($calscale) {
    $this->calscale = $calscale;
    return $this;
  }

  public function getProdid() {
    return $this->prodid;
  }
  public function setProdid($prodid) {
    $this->prodid = $prodid;
    return $this;
  }

  public function getDatas() {
    // @TODO find simple $this[protected:] export
    return array(
      'version' => $this->version,
      'method' => $this->method,
      'calscale' => $this->calscale,
      'prodid' => $this->prodid,
    );
  }

  public static function parseObject(Objects $doc, $content) {
    return preg_replace_callback('`BEGIN:VCALENDAR(.*)END:VCALENDAR`sUi', function($matche) use(&$doc) {
        
        $entity = new \ICS\Element\Calendar($matche[1]);
        // sub `begin:`
        $matche[1] = $entity->parse();

        // variables
        $matche[1] = preg_replace_callback('`^[[:blank:]]*([A-Z]+):(.*)$`miU', function($m2) use(&$entity) {
          $m2[2] = trim($m2[2]);
          $entity->$m2[1] = $m2[2];
        }, $matche[1]);

        $doc->addChildren($entity);

        return $matche[1];
    }, $content);
  }

  public function saveObject($indent) {
    return $this->genericSaveObject($indent, 'BEGIN:VCALENDAR', 'END:VCALENDAR');
  }

  public function save($filename = null, $indent = false) {
    if( $filename === true )
      $filename = $this->filename;

    return parent::save($filename, $indent);
  }
}