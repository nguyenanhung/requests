<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/16/18
 * Time: 17:04
 */

namespace nguyenanhung\MyRequests;

use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\MyRequests\Interfaces\ProjectInterface;

/**
 * Class BackgroundRequest
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class BackgroundRequest implements ProjectInterface, BackgroundRequestInterface
{
    /** @var object \nguyenanhung\MyDebug\Benchmark */
    private $benchmark;
    /** @var object \nguyenanhung\MyDebug\Debug Call to class */
    private $debug;
    /** @var bool Set Debug Status */
    public $debugStatus = FALSE;
    /** @var null|string Set level Debug: DEBUG, INFO, ERROR .... */
    public $debugLevel = NULL;
    /** @var null|string Set Logger Path to Save */
    public $debugLoggerPath = NULL;
    /** @var null|string Set Logger Filename to Save */
    public $debugLoggerFilename;

    /**
     * BackgroundRequest constructor.
     */
    public function __construct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark = new Benchmark();
            $this->benchmark->mark('code_start');
        }
        $this->debug = new Debug();
        if (empty($this->debugLoggerPath)) {
            $this->debugStatus = FALSE;
        }
        $this->debug->setDebugStatus($this->debugStatus);
        $this->debug->setGlobalLoggerLevel($this->debugLevel);
        $this->debug->setLoggerPath($this->debugLoggerPath);
        $this->debug->setLoggerSubPath(__CLASS__);
        if (empty($this->debugLoggerFilename)) {
            $this->debugLoggerFilename = 'Log-' . date('Y-m-d') . '.log';
        }
        $this->debug->setLoggerFilename($this->debugLoggerFilename);
        $this->debug->debug(__FUNCTION__, '/-------------------------> Begin Logger - My Background Request - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
    }

    /**
     * BackgroundRequest destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark->mark('code_end');
            $this->debug->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->debug->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
        $this->debug->debug(__FUNCTION__, '/-------------------------> End Logger - My Background Request - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
    }

    /**
     * Function getVersion
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/7/18 02:24
     *
     * @return mixed|string Current Project Version
     * @example string 0.1.3
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Hàm gọi 1 async GET Request để không delay Main Process
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:15
     *
     * @param string $url Url Endpoint
     *
     * @return bool TRUE nếu thành công, FALSE nếu thất bại
     */
    public static function backgroundHttpGet($url)
    {
        $parts = parse_url($url);
        if ($parts['scheme'] == 'https') {
            $fp = fsockopen('ssl://' . $parts['host'], isset($parts['port']) ? $parts['port'] : 443, $errno, $errstr, 30);
        } else {
            $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);
        }
        if (!$fp) {
            if (function_exists('log_message')) {
                log_message('error', "ERROR: " . json_encode($errno) . " - " . json_encode($errstr));
            }

            return FALSE;
        } else {
            $out = "GET " . $parts['path'] . "?" . $parts['query'] . " HTTP/1.1\r\n";
            $out .= "Host: " . $parts['host'] . "\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
            fclose($fp);

            return TRUE;
        }
    }

    /**
     * Hàm gọi 1 async POST Request để không delay Main Process
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:16
     *
     * @param string $url         Url Endpoint
     * @param string $paramString Params to Request
     *
     * @return bool TRUE nếu thành công, FALSE nếu thất bại
     */
    public static function backgroundHttpPost($url, $paramString = '')
    {
        $parts = parse_url($url);
        if ($parts['scheme'] == 'https') {
            $fp = fsockopen('ssl://' . $parts['host'], isset($parts['port']) ? $parts['port'] : 443, $errno, $errstr, 30);
        } else {
            $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);
        }
        if (!$fp) {
            if (function_exists('log_message')) {
                log_message('error', "ERROR: " . json_encode($errno) . " - " . json_encode($errstr));
            }

            return FALSE;
        } else {
            $out = "POST " . $parts['path'] . "?" . $parts['query'] . " HTTP/1.1\r\n";
            $out .= "Host: " . $parts['host'] . "\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "Content-Length: " . strlen($paramString) . "\r\n";
            $out .= "Connection: Close\r\n\r\n";
            if ($paramString != '') {
                $out .= $paramString;
            }
            fwrite($fp, $out);
            fclose($fp);

            return TRUE;
        }
    }
}
