<?php

namespace ICS\Element;
use ICS\Objects;
use ICS\DateTime as ICSDateTime;

/**
 * Event
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
Class Event extends Objects {
  protected $dtstamp;
  protected $dtstart;
  protected $dtend;
  protected $created;
  protected $description;
  protected $summary;
  protected $sequence;
  protected $location;
  protected $uid;

  public function __set($name, $value) {
    $this->{strtolower($name)} = $value;
  }

  public function getDateStart($format = null) {
    return ($format && $this->dtstart instanceof \DateTime) ? $this->dtstart->format($format) : $this->dtstart;
  }
  public function setDateStart(\DateTime $date) {
    $this->dtstart = new ICSDateTime($date);
    return $this;
  }

  public function getDateEnd($format = null) {
    return ($format && $this->dtend instanceof \DateTime) ? $this->dtend->format($format) : $this->dtend;
  }
  public function setDateEnd(\DateTime $date) {
    $this->dtend = new ICSDateTime($date);
    return $this;
  }

  public function getDateCreated($format = null) {
    return ($format && $this->created instanceof \DateTime) ? $this->created->format($format) : $this->created;
  }
  public function setDateCreated(\DateTime $date) {
    $this->dtcreated = new ICSDateTime($date);
    return $this;
  }

  public function getDateStamp($format = null) {
    return ($format && $this->dtstamp instanceof \DateTime) ? $this->dtstamp->format($format) : $this->dtstamp;
  }
  public function setDateStamp(\DateTime $date) {
    $this->dtstamp = new ICSDateTime($date);
    return $this;
  }

  public function getDescription($br = true) {
    return $br ? str_replace('\n', PHP_EOL, $this->description) : $this->description;
  }
  public function setDescription($description) {
    $this->description = str_replace(PHP_EOL, '\n', $description);
    return $this;
  }

  public function getSummary() {
    return $this->summary;
  }
  public function setSummary($summary) {
    $this->summary = $summary;
    return $this;
  }

  public function getSequence() {
    return $this->sequence;
  }
  public function setSequence($sequence) {
    $this->sequence = $sequence;
    return $this;
  }

  public function getUID() {
    return $this->uid;
  }
  public function setUID($uid) {
    $this->uid = $uid;
    return $this;
  }

  public function getLocation() {
    return $this->location;
  }
  public function setLocation($location) {
    $this->location = $location;
    return $this;
  }

  public function getDatas() {
    // @TODO find simple $this[protected:] export
    return array(
      'dtstamp' => $this->dtstamp,
      'dtstart' => $this->dtstart,
      'dtend' => $this->dtend,
      'created' => $this->created,
      'description' => $this->description,
      'summary' => $this->summary,
      'sequence' => $this->sequence,
      'location' => $this->location,
      'uid' => $this->uid,
    );
  }

  /**
   * parseObject
   * @Override
   */
  public static function parseObject(Objects $doc, $content) {
    return preg_replace_callback('`[[:space:]]*BEGIN:VEVENT(.*)END:VEVENT`sUi', function($matche) use(&$doc) {
    
        // VEvent parser
        $event = new self($matche[1]);
        $r = preg_replace_callback('`^[[:blank:]]*([A-Z]+)[;VALUE\=DATE]*:(.*)$`mi', function($m2) use(&$doc, $event) {
          $m2[2] = trim($m2[2]);
          switch($m2[1]) {
            case 'DTSTAMP' :
            case 'DTSTART' :
            case 'DTEND' :
            case 'CREATED' :
              $event->$m2[1] = new ICSDateTime($m2[2]);
              break;

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
    $return[] = 'BEGIN:VEVENT';

    foreach( $this->getDatas() as $name => $value ) {
      if( $value !== null && !is_array($value) )
        $return[] = '  ' . strtoupper($name) . ':' . trim($value);
    }

    foreach( $this->getChildren() as $event ) {
      $return[] = '  ' . implode(PHP_EOL . '  ', explode(PHP_EOL, $event->save()));
    }

    $return[] = 'END:VEVENT';

    return '  ' . implode(PHP_EOL . '  ', $return);
  }

}

?>