<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/30/18
 * Time: 17:11
 */

namespace nguyenanhung\MyRequests\Helpers\Interfaces;

interface DebugInterface
{
    /**
     * Function getDebugStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:52
     *
     * @return mixed
     */
    public function getDebugStatus();

    /**
     * Function setDebugStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:52
     *
     * @param bool $debug
     *
     * @return mixed
     */
    public function setDebugStatus($debug = FALSE);

    /**
     * Function getLoggerPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:52
     *
     * @return mixed
     */
    public function getLoggerPath();

    /**
     * Function setLoggerPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:52
     *
     * @param string $logger_path
     *
     * @return mixed
     */
    public function setLoggerPath($logger_path = '');

    /**
     * Function getLoggerSubPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 19:03
     *
     * @return mixed
     */
    public function getLoggerSubPath();

    /**
     * Function setLoggerSubPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 19:03
     *
     * @param string $sub_path
     *
     * @return mixed
     */
    public function setLoggerSubPath($sub_path = '');

    /**
     * Function getLoggerFilename
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:52
     *
     * @return mixed
     */
    public function getLoggerFilename();

    /**
     * Function setLoggerFilename
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:52
     *
     * @param string $logger_filename
     *
     * @return mixed
     */
    public function setLoggerFilename($logger_filename = '');

    /**
     * Function log
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:30
     *
     * @param string $level
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function log($level = '', $name = 'log', $msg = '', $context = []);

    /**
     * Function debug
     * DEBUG (100): Detailed debug information.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:33
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function debug($name = 'log', $msg = '', $context = []);

    /**
     * Function info
     * INFO (200): Interesting events. Examples: User logs in, SQL logs.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:33
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function info($name = 'log', $msg = '', $context = []);

    /**
     * Function notice
     * NOTICE (250): Normal but significant events.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:33
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function notice($name = 'log', $msg = '', $context = []);

    /**
     * Function warning
     * WARNING (300): Exceptional occurrences that are not errors.
     * Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:33
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function warning($name = 'log', $msg = '', $context = []);

    /**
     * Function error
     * ERROR (400): Runtime errors that do not require immediate action but should typically be logged and monitored.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:33
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function error($name = 'log', $msg = '', $context = []);

    /**
     * Function critical
     * CRITICAL (500): Critical conditions.
     * Example: Application component unavailable, unexpected exception.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:33
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function critical($name = 'log', $msg = '', $context = []);

    /**
     * Function alert
     * ALERT (550): Action must be taken immediately.
     * Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:33
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function alert($name = 'log', $msg = '', $context = []);

    /**
     * Function emergency
     * EMERGENCY (600): Emergency: system is unusable.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:33
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return mixed
     */
    public function emergency($name = 'log', $msg = '', $context = []);
}
