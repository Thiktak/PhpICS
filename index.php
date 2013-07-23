<?php

// We work with date ... so :
date_default_timezone_set('Europe/paris');

include 'PhpICS/ICS/index.php';


try {
  $icalc = ICS\ICS::open('test.ics');
//$icalc = ICS\ICS::load( file_get_contents('test.ics') );

  foreach( $icalc as $event ) {
    
  echo <<<EOL
<h2>[uid:{$event->getUid()}] at {$event->getDateStart('Y-m-d H:i:s')}</h2>
<p>{$event->getSummary()}</p>

EOL;
    echo '<br />';
  }

  echo '<pre>', $icalc, '</pre>';


  echo '<h1>Edit summary of the first Event</h1>';

  $event = $icalc->getCalendar()->getChild(0);
  $event->setSummary('test');

  echo '<pre>', $icalc, '</pre>';



  echo  '<h1>Create Event with addChildren(ICSVEvent $object)</h1>';

  $event = $icalc->getCalendar()->addChildren(new ICS\Element\Event());
  $event->setDateStart(new \DateTime(null));
  $event->setSummary('Event 1');

  echo '<pre>', $event, '</pre>';


  echo '<h1>Create Event with addChildren(\'event\')</h1>';

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