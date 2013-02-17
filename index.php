<?php

// We work with date ... so :
date_default_timezone_set('Europe/paris');

include 'PhpICS/ICS/index.php';


try {
  $icalc = ICS\ICS::open('test.ics');
//$icalc = ICS\ICS::load( file_get_contents('test.ics') );

  foreach( $icalc as $event ) {
    echo $event->getDateStart('Y-m-d H:i:s'), ' - ', $event->getSummary();
    echo '<br />';
  }

  echo '<pre>', $icalc, '</pre>';


  // Edit summary of the first Event

  $event = $icalc->getCalendar()->getChild(0);
  $event->setSummary('test');

  echo '<pre>', $icalc, '</pre>';


  // Create Event with addChildren(ICSVEvent $object)

  $event = $icalc->getCalendar()->addChildren(new ICS\Element\Event());
  $event->setDateStart(new \DateTime(null));
  $event->setSummary('Event 1');


  // Create Event with addChildren('event')

  $event = $icalc->getCalendar()->addChildren('event');
  $event->setDateStart(new \DateTime(null));
  $event->setSummary('Event 2');


  echo '<pre>', $icalc, '</pre>';

  // echo $icalc
  // echo $icalc->save();

  // $icalc->save(true) save the ICalendar into test.ics
  // $icalc->save('file.ics') save the ICalendar into `file.ics`
}
catch(ICSException $e) {
  echo 'Error : ', $e->getMessage();
}
?>