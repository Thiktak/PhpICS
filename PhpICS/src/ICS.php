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

  public function __construct($content, $filename = null) {
    $this->filename = $filename;

    $this->document = new ICSVCalendar($content);
  }

  public function getIterator() {
    return $this->document->getIterator();
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

  public function parse() {
    return $this->document->parse();
  }

  public static function parseObject(ICSObjects $doc, $content) {
  }

  public function saveObject() {
    return $this->document->saveObject();
  }
}