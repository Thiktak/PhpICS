<?php

Class ICSDateTime extends \DateTime {
  public function __toString() {
    return $this->format('Ymd\THis\Z');
  }
}