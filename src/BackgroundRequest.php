<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/16/18
 * Time: 17:04
 */

namespace nguyenanhung\MyRequests;

use nguyenanhung\MyDebug\Logger;
use nguyenanhung\MyDebug\Benchmark;

/**
 * Class BackgroundRequest
 *
 * @package   nguyenanhung\MyRequests
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class BackgroundRequest implements ProjectInterface
{
     const REQUEST_TIMEOUT = 30;
     const PORT_SSL        = 443;
     const PORT_HTTP       = 80;

    use Version;

    /** @var object \nguyenanhung\MyDebug\Benchmark */
    private $benchmark;

    /** @var object \nguyenanhung\MyDebug\Debug Call to class */
    private $logger;

    /** @var bool Set Debug Status */
    public $debugStatus = false;

    /** @var null|string Set level Debug: DEBUG, INFO, ERROR .... */
    public $debugLevel = 'error';

    /** @var string Set Logger Path to Save */
    public $debugLoggerPath = '';

    /** @var string|null Set Logger Filename to Save */
    public $debugLoggerFilename = '';

    /**
     * BackgroundRequest constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        if (self::USE_BENCHMARK === true) {
            $this->benchmark = new Benchmark();
            $this->benchmark->mark('code_start');
        }
        $this->logger = new Logger();
        if (empty($this->debugLoggerPath)) {
            $this->debugStatus = false;
        }
        $this->logger->setDebugStatus($this->debugStatus);
        $this->logger->setGlobalLoggerLevel($this->debugLevel);
        $this->logger->setLoggerPath($this->debugLoggerPath);
        $this->logger->setLoggerSubPath(__CLASS__);
        if (empty($this->debugLoggerFilename)) {
            $this->debugLoggerFilename = 'Log-' . date('Y-m-d') . '.log';
        }
        $this->logger->setLoggerFilename($this->debugLoggerFilename);
    }

    /**
     * BackgroundRequest destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === true) {
            $this->benchmark->mark('code_end');
            $this->logger->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->logger->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
    }

    /**
     * Hàm gọi 1 async GET Request để không delay Main Process
     *
     * @param string $url Url Endpoint
     *
     * @return bool TRUE nếu thành công, FALSE nếu thất bại
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/16/18 17:15
     */
    public static function backgroundHttpGet(string $url): bool
    {
        $parts = parse_url($url);
        if (strtolower($parts['scheme']) === 'https') {
            $fp = fsockopen('ssl://' . $parts['host'], $parts['port'] ?? self::PORT_SSL, $errno, $errStr, self::REQUEST_TIMEOUT);
        } else {
            $fp = fsockopen($parts['host'], $parts['port'] ?? self::PORT_HTTP, $errno, $errStr, self::REQUEST_TIMEOUT);
        }
        if (!$fp) {
            if (function_exists('log_message')) {
                log_message('error', "ERROR: " . json_encode($errno) . " - " . json_encode($errStr));
            }

            return false;
        }

        $out = "GET " . $parts['path'] . "?" . $parts['query'] . " HTTP/1.1\r\n";
        $out .= "Host: " . $parts['host'] . "\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        fclose($fp);

        return true;
    }

    /**
     * Hàm gọi 1 async POST Request để không delay Main Process
     *
     * @param string $url         Url Endpoint
     * @param string $paramString Params to Request
     *
     * @return bool TRUE nếu thành công, FALSE nếu thất bại
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/16/18 17:16
     */
    public static function backgroundHttpPost(string $url, string $paramString = ''): bool
    {
        $parts = parse_url($url);
        if ($parts['scheme'] === 'https') {
            $fp = fsockopen('ssl://' . $parts['host'], $parts['port'] ?? self::PORT_SSL, $errno, $errStr, self::REQUEST_TIMEOUT);
        } else {
            $fp = fsockopen($parts['host'], $parts['port'] ?? self::PORT_HTTP, $errno, $errStr, self::REQUEST_TIMEOUT);
        }
        if (!$fp) {
            if (function_exists('log_message')) {
                log_message('error', "ERROR: " . json_encode($errno) . " - " . json_encode($errStr));
            }

            return false;
        }

        $out = "POST " . $parts['path'] . "?" . $parts['query'] . " HTTP/1.1\r\n";
        $out .= "Host: " . $parts['host'] . "\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "Content-Length: " . strlen($paramString) . "\r\n";
        $out .= "Connection: Close\r\n\r\n";
        if ($paramString !== '') {
            $out .= $paramString;
        }
        fwrite($fp, $out);
        fclose($fp);

        return true;
    }
}
