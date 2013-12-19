<?php

namespace ICS;

/**
 * ICSObjects
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
abstract class Objects implements iObjects, \IteratorAggregate {

  protected $children;
  protected $content;
  protected $parsers = array();

  public function __construct($content = null) {
    $this->content = trim($content);
  }

  public function getIterator() {
    return new \ArrayObject((array) $this->children);
  }

  public function getChildren() {
    return (array) $this->children;
  }

  public function getChild($index) {
    return $this->children[$index];
  }

  public function getMetas() {
    $metas = array();
    $rc = new \ReflectionClass($this);
    foreach( $rc->getProperties() as $var )
      switch($var->getName()) {
        case 'children':
        case 'parsers':
        case 'content':
          break;
        default;
          $var->setAccessible(true);
          $metas[$var->getName()] = $var->getValue($this);
          break;
      }
    return $metas;
  }

  public function addChildren($child) {

    if( is_string($child) ) {
      $class = 'ICS\\Element\\' . $child;
      if( class_exists($class) )
        $child = new $class();
    }

    if( !is_array($this->children) )
        throw new Exception('You can\'t attach children into this node');

    if( !($child instanceof Objects) )
        throw new Exception('Argument 1 passed to ICSObjects::addChildren() must be an instance of ICSObjects');

    $this->children[] = $child;
    return $child;
  }

  public function parse() {
    $content = $this->content;
    foreach( (array) $this->parsers as $parser ) {
      $parser = 'ICS\\Element\\' . $parser;
      if( !is_subclass_of($parser, 'ICS\\Objects') )
        throw new Exception(sprintf('Child `%s` object must be an instance of ICS\\Objects', $parser));
      
      // @TODO: To edit
      $content2 = null;
      foreach( explode(PHP_EOL, $content) as $line )
        if( preg_match('`^([A-Z:=]+:)`', trim($line)) )
          $content2 .= PHP_EOL . trim($line); // single-line prop.
        else
          $content2 .= trim($line); // multi-line prop. (\n)

      $content = $parser::parseObject($this, trim($content2));
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