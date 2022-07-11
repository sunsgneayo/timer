<?php


//$eventConfig = new EventConfig();
//$eventBase   = new EventBase($eventConfig);
//$event       = new Event($eventBase, -1, Event::TIMEOUT | Event::PERSIST, function () {
//    echo 'date:' . date('Y-m-d H:i:s') . PHP_EOL;
//});
//$event->add(1);
//$eventBase->loop();

$event = new \Sunsgne\EventTimer();

$event->add(1 , function (){

} , [] , true);

$event->run();