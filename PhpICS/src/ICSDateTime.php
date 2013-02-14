<?php

/**
 * ICSDateTime
 * 
 * @author Olivarès Georges <dev@olivares-georges.fr>
 *
 */
Class ICSDateTime extends \DateTime {
  public function __toString() {
    return $this->format('Ymd\THis\Z');
  }
}