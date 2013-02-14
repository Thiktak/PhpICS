<?php

/**
 * ICSObjects
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
abstract class ICSObjects implements ICSiObjects, IteratorAggregate {

  protected $children;
  protected $content;
  protected $parsers = array();

  public function __construct($content = null) {
    $this->content = trim($content);
  }

  public function getIterator() {
    return new ArrayObject((array) $this->children);
  }

  public function getChildren() {
    return (array) $this->children;
  }

  public function getChild($index) {
    return $this->children[$index];
  }

  public function addChildren(ICSObjects $child) {
    if( !is_array($this->children) )
        throw new ICSException('You can\'t attach children into this node');

    $this->children[] = $child;
    return $this;
  }

  public function parse() {
    $content = $this->content;
    foreach( (array) $this->parsers as $parser ) {
      if( $parser instanceof ICSObject )
        throw new ICSException('Child object must be instance of ICSObject');

      $content = $parser::parseObject($this, $content);
    }

    return $content;
  }

  public function save($filename = null) {

    $content = $this->saveObject();

    if( $filename )
      file_put_contents($filename, $content);

    return $content;
  }


  public function __set($name, $value) {
    if( !is_array($this->{strtolower($name)}) )
      $this->{strtolower($name)} = $value;
  }

  public function __toString() {
    return (String) $this->save(null);
  }
}

?>