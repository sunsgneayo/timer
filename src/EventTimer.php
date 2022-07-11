<?php

namespace Sunsgne;

use EventConfig;
use EventBase;
use Event;
/**
 * @purpose
 * @date 2022/7/11
 * @author zhulianyou
 */
class EventTimer
{

    protected EventBase $eventBase;

    public function __construct()
    {
        $config = new EventConfig();
        if (\DIRECTORY_SEPARATOR !== '\\') {
            $config->requireFeatures(\EventConfig::FEATURE_FDS);
        }
        $this->eventBase = new EventBase($config);
    }


    public  function add(float $interval, callable $func, array $argv = array(), bool $persist = false , bool $delay = false)
    {

        $event = new Event($this->eventBase, -1, \Event::TIMEOUT, function ($argv) use(&$event, $interval, $func){
            $id = spl_object_hash($event);
            $func($argv);
            $event = new Event($this->eventBase, -1, \Event::TIMEOUT | \Event::PERSIST, $func);
            $event->add($interval);
        });
        $event->add($delay);
    }

    public static function dellAll()
    {
        // TODO: Implement dellAll() method.
    }

    public static function signalHandler()
    {
        // TODO: Implement signalHandler() method.
    }
    public static function installHandler()
    {
        // TODO: Implement installHandler() method.
    }

    public  function run()
    {
        $this->eventBase->loop();
    }
}