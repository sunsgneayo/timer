<?php
require_once "./vendor/autoload.php";
use Sunsgne\Timer;

Timer::dellAll();

Timer::add( 5, function (...$p){
    var_dump(time());
    echo  "我是定时任务执行的方法" .PHP_EOL;
}, [time()],true , true);


var_dump(Timer::getTaskAll());
Timer::run();

while(1)
{
    sleep(1);
    pcntl_signal_dispatch();
}