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

### List events
```php
// list childs
foreach( $icalc as $event ) {
  echo $event->getDateStart(), ' ';
  echo $event->getSummary(), ' ';
  echo $event->getUID(), ' ';
}
```
See **Event** paragraph

### Edit event
```php
$event = $icalc->getCalendar()->getChild(0); // return first child
$event->setSummary('test'); // edit Summary
```

### Create new calendar
```php
$new_calendar = new ICS\Element\Calendar();
$new_calendar->setName("Important meetings");
$new_calendar->setVersion("2.0");
$new_calendar->setCalscale("Gregorian");
$new_calendar->setProdid("PhpICS");

echo $new_calendar->save();
```

### Setting/Getting calendar extended fields

```php
 $new_calendar->setName("Work calendar");
 $new_calendar->setTimezone("Europe/Athens");
 
 // set description
 $new_calendar->setExtended("X-WR-CALDESC", "Lorem ipsum");
 
 // Returns raw array of extended fields and values
 $new_calendar->getExtended();

 // Return array of all properties
 $new_calendar->getMetas();
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

### Export .ics
```php
$indent = true; // <=> $indent = '  ';

echo $new_calendar; // default toString();
echo $new_calendar($indent);

$new_calendar->save('filename'); // défault $indent=false
//$new_calendar->save('filename', true);
echo $new_calendar->save(null, $indent);

``

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

### Todo

### Journal

### Alarm

## Changelog
* v1.1.0 add **namespace**
* v1.0.1 refactorized code
* v1.0.0 create PhpICS 

[![githalytics.com alpha](https://cruel-carlota.pagodabox.com/ee8f7e97afe4120059749eb24f4cca34 "githalytics.com")](http://githalytics.com/Thiktak/PhpICS)
