<?php

// We work with date ... so :
date_default_timezone_set('Europe/paris');


include 'PhpICS/src/index.php';

$icalc = ICS::open('test.ics');

foreach( $icalc as $event ) {
  echo $event->getDateStart('Y-m-d H:i:s'), ' - ', $event->getSummary();
  echo '<br />';
}

echo '<pre>', $icalc, '</pre>';
// echo $icalc
// echo $icalc->save();

// $icalc->save(true) save the ICalendar into test.ics
// $icalc->save('file.ics') save the ICalendar into `file.ics`


?>