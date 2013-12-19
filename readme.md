# PHP ICS

This class is under LGPU license.

## How to use ?
```php
<?php

date_default_timezone_set('Europe/Paris');
include 'PhpICS/ICS/index.php';

$icalc = ICS\ICS::open('test.ics');
// $icalc = ICS\ICS::load(file_get_content('test.ics'));

foreach( $icalc as $event ) {
  echo $event->getDateStart('Y-m-d H:i:s'), ' - ', $event->getSummary(), '<br />';
}

echo '<pre>', $icalc, '</pre>';
```

### list events
```php
// list childs
foreach( $icalc as $event ) {
  echo $event->getDateStart(), ' ';
  echo $event->getSummary(), ' ';
  echo $event->getUID(), ' ';
}
```
See **Event** paragraph

### edit event
```php
$event = $icalc->getCalendar()->getChild(0); // return first child
$event->setSummary('test'); // edit Summary
```

### Create new calendar
```php
$new_calendar = new ICS\Element\Calendar();
$icalc = ICS\ICS::load($new_calendar->save());
```

### Create event
object method
```php
$event = $icalc->getCalendar()->addChildren(new ICS\Element\Event());
$event->setDateStart(new \DateTime(null));
$event->setSummary('Event 1');
```
String method
```php
$event = $icalc->getCalendar()->addChildren('event');
$event->setDateStart(new \DateTime(null));
$event->setSummary('Event 2');
```

More infos into the sources

## Elements
### Event
* date stamp ( *getDateStamp($format = null)*, *setDateStamp(DateTime $time)*)
* date start ( *getDateStamp($format = null)*, *setDateStart(DateTime $time)*)
* date end ( *getDateEnd($format = null)*, *setDateEnd(DateTime $time)*)
* date created ( *getDateCreated($format = null)*, *setDateCreated(DateTime $time)*)
* description ( *getDateStamp($format = null)*, *setDateStart(DateTime $time)*)
* summary ...
* sequence ...
* location ...
* uid ...

### Calendar
* version
* method
* calscale
* prodid

## Changelog
* v1.1.0 add **namespace**
* v1.0.1 refactorized code
* v1.0.0 create PhpICS 

[![githalytics.com alpha](https://cruel-carlota.pagodabox.com/ee8f7e97afe4120059749eb24f4cca34 "githalytics.com")](http://githalytics.com/Thiktak/PhpICS)
