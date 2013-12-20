<?php

namespace ICS\Element;
use ICS\Objects;
use ICS\DateTime as ICSDateTime;

/**
 * Alarm
 * 
 * @author Olivarès Georges <dev@olivares-georges.net>
 *
 */
Class Alarm extends Objects {
  protected $action;
  protected $trigger;
  protected $attach;
  protected $repeat;
  protected $duration;

  public function __set($name, $value) {
    $this->{strtolower($name)} = $value;
  }

  public function getAction() {
    return $this->action;
  }
  public function setAction($action) {
    $this->action = $action;
    return $this;
  }

  public function getTrigger() {
    return $this->trigger;
  }
  public function setTrigger($trigger) {
    $this->trigger = $trigger;
    return $this;
  }

  public function getAttach() {
    return $this->attach;
  }
  public function setAttach($attach) {
    $this->attach = $attach;
    return $this;
  }

  public function getRepeat() {
    return $this->repeat;
  }
  public function setRepeat($repeat) {
    $this->repeat = $repeat;
    return $this;
  }

  public function getDuration() {
    return $this->duration;
  }
  public function setDuration($duration) {
    $this->duration = $duration;
    return $this;
  }

  public function getDatas() {
    // @TODO find simple $this[protected:] export
    return array(
      'action' => $this->action,
      'trigger' => $this->trigger,
      'attach' => $this->attach,
      'repeat' => $this->repeat,
      'duration' => $this->duration,
    );
  }

  /**
   * parseObject
   * @Override
   */
  public static function parseObject(Objects $doc, $content) {
    return preg_replace_callback('`[[:space:]]*BEGIN:VALARM(.*)END:VALARM`sUi', function($matche) use(&$doc) {
    
        // VEvent parser
        $event = new self($matche[1]);
        $r = preg_replace_callback('`^[[:blank:]]*([A-Z]+)[;VALUE\=DATE]*[:;](.*)$`mi', function($m2) use(&$doc, $event) {
          $m2[2] = trim($m2[2]);
          switch($m2[1]) {
            default :
              $event->$m2[1] = $m2[2];
              break;
          }
        }, $matche[1]);
        $doc->addChildren($event);

        return null;
    }, $content);
  }

  /**
   * saveObject
   * @override
   */
  public function saveObject() {
    $return = array();
    $return[] = 'BEGIN:VALARM';

    foreach( $this->getDatas() as $name => $value ) {
      if( $value !== null && !is_array($value) )
        $return[] = '  ' . strtoupper($name) . ':' . trim($value);
    }

    foreach( $this->getChildren() as $event ) {
      $return[] = '  ' . implode(PHP_EOL . '  ', explode(PHP_EOL, $event->save()));
    }

    $return[] = 'END:VALARM';

    return '  ' . implode(PHP_EOL . '  ', $return);
  }

}

?>