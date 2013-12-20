<?php

namespace ICS;

/**
 * ICSDateTime
 * 
 * @author Olivarès Georges <dev@olivares-georges.net>
 *
 */
Class DateTime extends \DateTime {

  public function __construct($time, \DateTimeZone $timezone = null) {

    if( is_object($time) )
      $time = '@' . $time->format('U');      

    parent::__construct($time, $timezone);
  }

  public function __toString() {
    return $this->format('Ymd\THis\Z');
  }
}