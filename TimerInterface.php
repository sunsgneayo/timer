<?php

/**
 * @purpose
 * @date 2022/7/11
 * @author zhulianyou
 */
interface TimerInterface
{
    /** 加载处理
     * @return mixed
     * @datetime 2022/7/11 10:57
     * @author zhulianyou
     */
    public static function installHandler();


    public static function signalHandler();


    public static function run();

    public  function add(float $interval, callable $func, array $argv = array(), bool $persist = false , bool $delay = false);

    public static function dellAll();

}