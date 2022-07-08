<?php
namespace Sunsgne;

use Sunsgne\Exception\TimerException;

/**
 * @purpose 定时器类
 * @date 2022/7/7
 * @author zhulianyou
 */
class Timer
{


    /** @var array 任务集合 */
    public static $task = [];


    /** @var int 任务隔离时间/秒 */
    public static $time = 1;

    /**
     * 运行定时器
     * @param $time
     * @return void
     * @datetime 2022/7/7 11:30
     * @author zhulianyou
     */
    public static function run($time = null)
    {
        if ($time) {
            self::$time = $time;
        }
        self::installHandler();
        pcntl_alarm(1);
    }

    /**
     * 注册信号处理函数
     * @return void
     * @datetime 2022/7/7 11:31
     * @author zhulianyou
     */
    public static function installHandler()
    {
        pcntl_signal(SIGALRM, array('Sunsgne\Timer', 'signalHandler'));
    }

    /**
     * 信号处理函数
     * @return void
     * @datetime 2022/7/7 11:31
     * @author zhulianyou
     */
    public static function signalHandler()
    {
        self::tick();
        //一次信号事件执行完成后,再触发下一次
        pcntl_alarm(self::$time);
    }

    /**
     * Tick .
     * @return void
     * @datetime 2022/7/7 11:28
     * @throws TimerException
     * @author zhulianyou
     */
    public static function tick()
    {
        if (empty(self::$task)) {
            \pcntl_alarm(0);
            return;
        }
        $current = time();
        foreach (self::$task as $time => $arr) {
            if ($current >= $time)
            {
                foreach ($arr as $k => $job) {
                    $func     = $job['func'];
                    $argv     = $job['argv'];
                    $interval = $job['interval'];
                    $persist  = $job['persist'];
                    try {
                        call_user_func_array($func, $argv);
                    }catch (\Exception $exception)
                    {
                        throw new TimerException($exception->getMessage());
                    }

                    /** 重置该任务 */
                    unset(self::$task[$time][$k]);

                    /** 任务持久化捕获 */
                    if ($persist) {
                        self::$task[$current + $interval][] = $job;
                    }
                }
            }


            if (empty(self::$task[$time])) {
                unset(self::$task[$time]);
            }
        }
    }

    /**
     * @param float $interval
     * @param callable $func
     * @param array $argv
     * @param bool $persist
     * @param bool $delay
     * @return void
     * @datetime 2022/7/7 11:15
     * @author zhulianyou
     */
    public static function add(float $interval, callable $func, array $argv = array(), bool $persist = false , bool $delay = false)
    {
        if ($interval <= 0) {
            return;
        }

        if ($argv === null) {
            $argv = array();
        }

        if ($delay === true)
        {
            call_user_func_array($func, $argv);
        }

        $time = time() + $interval;
        /** 往任务集合追加任务 */
        self::$task[$time][] = array('func' => $func, 'argv' => $argv, 'interval' => $interval, 'persist' => $persist);
    }

    /**
     * 重置任务集合
     * @return void
     * @datetime 2022/7/7 11:34
     * @author zhulianyou
     */
    public static function dellAll()
    {
        self::$task = array();
    }

    /**
     * 获取所有任务集合
     * @return array
     * @datetime 2022/7/7 11:36
     * @author zhulianyou
     */
    public static function getTaskAll(): array
    {
        return self::$task;
    }
}