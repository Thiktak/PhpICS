<?php

Class ICSVEvent extends ICSObjects {
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
    return ($format && $this->dtstart instanceof DateTime) ? $this->dtstart->format($format) : $this->dtstart;
  }
  public function setDateStart(DateTime $date) {
    $this->dtstart = $date;
    return $this;
  }

  public function getDateEnd($format = null) {
    return ($format && $this->dtend instanceof DateTime) ? $this->dtend->format($format) : $this->dtend;
  }
  public function setDateEnd(DateTime $date) {
    $this->dtend = $date;
    return $this;
  }

  public function getDateCreated($format = null) {
    return ($format && $this->created instanceof DateTime) ? $this->created->format($format) : $this->created;
  }
  public function setDateCreated(DateTime $date) {
    $this->dtcreated = $date;
    return $this;
  }

  public function getDateStamp($format = null) {
    return ($format && $this->dtstamp instanceof DateTime) ? $this->dtstamp->format($format) : $this->dtstamp;
  }
  public function setDateStamp(DateTime $date) {
    $this->dtstamp = $date;
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

  public static function parseObject(ICSDocument $doc, $content) {
    return preg_replace_callback('`[[:space:]]*BEGIN:VEVENT(.*)END:VEVENT`sUi', function($matche) use(&$doc) {
    
        // VEvent parser

        $event = new ICSVEvent();
        preg_replace_callback('`^[[:blank:]]*([A-Z]+):(.*)$`miU', function($m2) use(&$doc, $event) {
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
        
        // /VEvent

    }, $content);
  }

  public function saveObject() {
    $return = array();
    $return[] = 'BEGIN:VEVENT';

    $r = new ReflectionClass($this);

    foreach( $r->getProperties() as $property ) {
      $property->setAccessible(true);
      if( $property->getValue($this) !== null && !is_array($property->getValue($this)) )
        $return[] = '  ' . strtoupper($property->getName()) . ':' . trim($property->getValue($this));
    }

    $return[] = 'END:VEVENT';



    return '  ' . implode(PHP_EOL . '  ', $return);
  }

}

?>