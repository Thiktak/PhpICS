<?php

namespace ICS;

/**
 * ICS
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
Class ICS extends Objects {
  /**
   * string $filename
   *  Name of the file
   */
  protected $filename;

  /**
   * string $document
   *  Content document
   */
  protected $document;

  /**
   * ICSObjects[] $children
   *  List of children (ICSObjects)
   */
  protected $children = array();

  /**
   * string[] $parsers
   *  List of ICSObjects available with this Object
   */
  protected $parsers = array('Calendar');



  public function __construct($content, $filename = null) {
    $this->filename = $filename;
    $this->content = $content;
  }

  /**
   * load
   * @param string $content Content of the document
   * @param string $filename
   * @return ICS
   */
  public static function load($content, $filename = null) {
    $doc = new self($content, $filename);
    $doc -> parse();
    return $doc;
  }

  /**
   * open
   * @param string $filename
   * @return ICS
   */
  public static function open($filename) {
    if( !file_exists($filename) )
      throw new ICSException(sprintf('failed to open stream: No such file `%s`', $filename));

    $content = file_get_contents($filename);
    return self::load($content, $filename);
  }

  /**
   * getIterator
   *   implemented from the interface IteratorAggregate
   * @return ICS
   */
  public function getIterator() {
    if( $this->children )
      return current($this->children)->getIterator();
    return new ArrayIterator();
  }
  
  /**
   * getCalendar
   * @return ICSVCalendar
   */
  public function getCalendar() {
    if( $this->children )
      return current($this->children);
    return null;
  }

  public static function parseObject(Objects $doc, $content) {
  }

  public function getMetas() {
    if( $this->children )
      return current($this->children)->getMetas();
    return null;
  }


  /**
   * saveObject
   * @return string
   */
  public function saveObject($indent = true) {
    $return = PHP_EOL;

    foreach( $this->getChildren() as $event ) {
      $return .= $event->save(null, $indent) . PHP_EOL;
    }
    return trim($return, PHP_EOL);
  }
}