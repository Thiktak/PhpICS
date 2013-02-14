<?php

abstract class ICSObjects implements ICSiObjects, IteratorAggregate {

  protected $children;
  protected $parsers = array();
  

  public function getIterator() {
    return new ArrayObject((array) $this->children);
  }

  public function getChildren() {
    return (array) $this->children;
  }

  public function addChildren(ICSObjects $child) {
    if( !is_array($this->children) )
        throw new Exception('You can\'t attach children into this node');

    $this->children[] = $child;
    return $this;
  }

  public function parse() {

    foreach( (array) $this->parsers as $parser ) {
      // @TODO if( $parser instanceof ICSObject )

      $this->content = $parser::parseObject($this, $this->content);
    }

    return $this;
  }

  public function save($filename = null) {

    $content = $this->saveObject();

    if( $filename )
      file_put_contents($filename, $content);

    return $content;
  }
}

?>