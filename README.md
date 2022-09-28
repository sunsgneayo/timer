<div align="center">
<img width="260px" src="https://cdn.sunsgne.top/logo-i.png" alt="sunsgne">

**<p align="center">sunsgne/timer</p>**

**<p align="center">🐬 Lightweight PHP timer implementation 🐬</p>**

# Lightweight PHP timer implementation

[![Latest Stable Version](http://poser.pugx.org/sunsgne/timer/v)](https://packagist.org/packages/sunsgne/timer)
[![Total Downloads](http://poser.pugx.org/sunsgne/timer/downloads)](https://packagist.org/packages/sunsgne/timer)
[![Latest Unstable Version](http://poser.pugx.org/sunsgne/timer/v/unstable)](https://packagist.org/packages/sunsgne/timer)
[![License](http://poser.pugx.org/sunsgne/timer/license)](https://packagist.org/packages/sunsgne/timer)
[![PHP Version Require](http://poser.pugx.org/sunsgne/timer/require/php)](https://packagist.org/packages/sunsgne/timer)
</div>
## Installation

```
composer require sunsgne/timer
```

## Basic Usage
```php
<?php
use Sunsgne\Timer;

require_once __DIR__ . '/vendor/autoload.php';

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
```
