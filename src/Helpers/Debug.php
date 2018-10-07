<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/27/18
 * Time: 18:31
 */

namespace nguyenanhung\MyRequests\Helpers;
if (!interface_exists('nguyenanhung\MyRequests\Interfaces\ProjectInterfaces')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}
if (!interface_exists('nguyenanhung\MyRequests\Helpers\Interfaces\DebugInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'DebugInterface.php';
}

use nguyenanhung\MyRequests\Interfaces\ProjectInterface;
use nguyenanhung\MyRequests\Helpers\Interfaces\DebugInterface;

class Debug implements ProjectInterface, DebugInterface
{
    private $DEBUG          = FALSE;
    private $loggerPath     = 'logs';
    private $loggerSubPath  = NULL;
    private $loggerFilename = 'app.log';

    /**
     * Debug constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:32
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function getDebugStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:33
     *
     * @return bool
     */
    public function getDebugStatus()
    {
        return $this->DEBUG;
    }

    /**
     * Function setDebugStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:33
     *
     * @param bool $debug
     */
    public function setDebugStatus($debug = FALSE)
    {
        $this->DEBUG = $debug;
    }

    /**
     * Function getLoggerPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:40
     *
     * @return string
     */
    public function getLoggerPath()
    {
        return $this->loggerPath;
    }

    /**
     * Function getLoggerSubPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 19:03
     *
     * @return mixed|null
     */
    public function getLoggerSubPath()
    {
        return $this->loggerSubPath;
    }

    /**
     * Function setLoggerPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:40
     *
     * @param string $logger_path
     */
    public function setLoggerPath($logger_path = '')
    {
        if (!empty($logger_path)) {
            $this->loggerPath = trim($logger_path);
        }
    }

    /**
     * Function setLoggerSubPath
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 19:04
     *
     * @param string $sub_path
     *
     * @return mixed|void
     */
    public function setLoggerSubPath($sub_path = '')
    {
        if (!empty($sub_path)) {
            $this->loggerSubPath = trim($sub_path) . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * Function getLoggerFilename
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:49
     *
     * @return string
     */
    public function getLoggerFilename()
    {
        return $this->loggerFilename;
    }

    /**
     * Function setLoggerFilename
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/27/18 18:49
     *
     * @param string $logger_filename
     */
    public function setLoggerFilename($logger_filename = '')
    {
        if (!empty($logger_filename)) {
            $this->loggerFilename = trim($logger_filename);
        }
    }

    /**
     * Function log
     * Add Log into Monolog
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:35
     *
     * @param string $level
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function log($level = '', $name = 'log', $msg = 'My Message', $context = [])
    {
        $level = strtolower(trim($level));
        if ($this->DEBUG == TRUE) {
            if (!class_exists('\Monolog\Logger')) {
                return FALSE;
            }
            try {
                $loggerSubPath = trim($this->loggerSubPath);
                if (!empty($loggerSubPath)) {
                    $loggerSubPath = Utils::slugify($loggerSubPath);
                }
                $listLevel = [
                    'debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'
                ];
                if (in_array($level, $listLevel)) {
                    $useLevel = $level;
                } else {
                    $useLevel = 'info';
                }
                switch ($useLevel) {
                    case 'debug':
                        $keyLevel = \Monolog\Logger::DEBUG;
                        break;
                    case 'info':
                        $keyLevel = \Monolog\Logger::INFO;
                        break;
                    case 'notice':
                        $keyLevel = \Monolog\Logger::NOTICE;
                        break;
                    case 'warning':
                        $keyLevel = \Monolog\Logger::WARNING;
                        break;
                    case 'error':
                        $keyLevel = \Monolog\Logger::ERROR;
                        break;
                    case 'critical':
                        $keyLevel = \Monolog\Logger::CRITICAL;
                        break;
                    case 'alert':
                        $keyLevel = \Monolog\Logger::ALERT;
                        break;
                    case 'emergency':
                        $keyLevel = \Monolog\Logger::EMERGENCY;
                        break;
                    default:
                        $keyLevel = \Monolog\Logger::DEBUG;
                }
                $loggerFilename = $this->loggerPath . DIRECTORY_SEPARATOR . $loggerSubPath . DIRECTORY_SEPARATOR . $this->loggerFilename;
                $dateFormat     = "Y-m-d H:i:s u";
                $output         = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
                $formatter      = new \Monolog\Formatter\LineFormatter($output, $dateFormat);
                $stream         = new \Monolog\Handler\StreamHandler($loggerFilename, $keyLevel, TRUE, 0777);
                $stream->setFormatter($formatter);
                $logger = new \Monolog\Logger(trim($name));
                $logger->pushHandler($stream);

                if (is_array($context)) {
                    return $logger->$useLevel($msg, $context);
                } else {
                    return $logger->$useLevel($msg . json_encode($context));
                }
            }
            catch (\Exception $e) {
                return FALSE;
            }
        }

        return NULL;
    }

    /**
     * Function debug
     * DEBUG (100): Detailed debug information.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:35
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function debug($name = 'log', $msg = 'My Message', $context = [])
    {
        return $this->log('debug', $name, $msg, $context);
    }

    /**
     * Function info
     * INFO (200): Interesting events.
     * Examples: User logs in, SQL logs.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:36
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function info($name = 'log', $msg = 'My Message', $context = [])
    {
        return $this->log('info', $name, $msg, $context);
    }

    /**
     * Function notice
     * NOTICE (250): Normal but significant events.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:37
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function notice($name = 'log', $msg = 'My Message', $context = [])
    {
        return $this->log('notice', $name, $msg, $context);
    }

    /**
     * Function warning
     * WARNING (300): Exceptional occurrences that are not errors.
     * Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:37
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function warning($name = 'log', $msg = 'My Message', $context = [])
    {
        return $this->log('warning', $name, $msg, $context);
    }

    /**
     * Function error
     * ERROR (400): Runtime errors that do not require immediate action but should typically be logged and monitored.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:37
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function error($name = 'log', $msg = 'My Message', $context = [])
    {
        return $this->log('error', $name, $msg, $context);
    }

    /**
     * Function critical
     * CRITICAL (500): Critical conditions.
     * Example: Application component unavailable, unexpected exception.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:38
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function critical($name = 'log', $msg = 'My Message', $context = [])
    {
        return $this->log('critical', $name, $msg, $context);
    }

    /**
     * Function alert
     * ALERT (550): Action must be taken immediately.
     * Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:38
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function alert($name = 'log', $msg = 'My Message', $context = [])
    {
        return $this->log('alert', $name, $msg, $context);
    }

    /**
     * Function emergency
     * EMERGENCY (600): Emergency: system is unusable.
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/6/18 23:38
     *
     * @param string $name
     * @param string $msg
     * @param array  $context
     *
     * @return bool|mixed|null
     */
    public function emergency($name = 'log', $msg = 'My Message', $context = [])
    {
        return $this->log('emergency', $name, $msg, $context);
    }
}
