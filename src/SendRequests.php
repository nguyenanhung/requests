<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 03:44
 */

namespace nguyenanhung\MyRequests;
if (!interface_exists('nguyenanhung\MyRequests\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}
if (!interface_exists('nguyenanhung\MyRequests\Interfaces\SendRequestsInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'SendRequestsInterface.php';
}

use nguyenanhung\MyRequests\Interfaces\ProjectInterface;
use nguyenanhung\MyRequests\Interfaces\SendRequestsInterface;
use nguyenanhung\MyRequests\Helpers\Debug;
use Requests;
use GuzzleHttp\Client;
use Curl\Curl;

class SendRequests implements ProjectInterface, SendRequestsInterface
{
    private $headers         = [];
    private $options         = [];
    private $timeout         = 60;
    private $debug;
    public  $debugStatus     = FALSE;
    public  $debugLoggerPath = NULL;
    public  $debugLoggerFilename;

    /**
     * SendRequests constructor.
     */
    public function __construct()
    {
        $this->debug = new Debug();
        if (empty($this->debugLoggerPath)) {
            $this->debugStatus = FALSE;
        }
        $this->debug->setDebugStatus($this->debugStatus);
        $this->debug->setLoggerPath($this->debugLoggerPath);
        $this->debug->setLoggerSubPath(__CLASS__);
        if (empty($this->debugLoggerFilename)) {
            $this->debugLoggerFilename = 'Log-' . date('Y-m-d') . '.log';
        }
        $this->debug->setLoggerFilename($this->debugLoggerFilename);
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 03:47
     *
     * @return mixed|string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function setHeaders
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 04:04
     *
     * @param array $headers
     */
    public function setHeaders($headers = [])
    {
        $this->headers = $headers;
        var_dump($this->debug->info(__FUNCTION__, 'setHeaders: ', $this->headers));
    }

    /**
     * Function setOptions
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 04:04
     *
     * @param array $options
     */
    public function setOptions($options = [])
    {
        $this->options = $options;
        $this->debug->info(__FUNCTION__, 'setOptions: ', $this->options);
    }

    /**
     * Function setTimeout
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 04:05
     *
     * @param int $timeout
     */
    public function setTimeout($timeout = 60)
    {
        $this->timeout = $timeout;
        $this->debug->info(__FUNCTION__, 'setTimeout: ', $this->timeout);
    }

    /**
     * Function pyRequest
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:07
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     *
     * @return null|\Requests_Response|string
     */
    public function pyRequest($url = '', $data = [], $method = 'GET')
    {
        $this->debug->debug(__FUNCTION__, '/---------------------------> ' . __FUNCTION__ . ' <---------------------------\\');
        $inputParams = [
            'url'    => $url,
            'data'   => $data,
            'method' => $method,
        ];
        $this->debug->info(__FUNCTION__, 'input Params: ', $inputParams);
        $method = strtoupper($method);
        if ((($method == self::GET || $method == self::HEAD || $method == self::TRACE || $method == self::DELETE) && !empty($data))) {
            $endpoint = trim($url) . '?' . http_build_query($data);
        } else {
            $endpoint = trim($url);
        }
        $this->debug->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        if (!class_exists('Requests')) {
            $this->debug->critical(__FUNCTION__, 'class Requests is not exits');
            $result = NULL;
        } else {
            try {
                if ($method == self::GET) {
                    $request = Requests::get($endpoint, $this->headers, $this->options);
                } elseif ($method == self::HEAD) {
                    $request = Requests::head($endpoint, $this->headers, $this->options);
                } elseif ($method == self::DELETE) {
                    $request = Requests::delete($endpoint, $this->headers, $this->options);
                } elseif ($method == self::TRACE) {
                    $request = Requests::trace($endpoint, $this->headers, $this->options);
                } elseif ($method == self::POST) {
                    $request = Requests::post($endpoint, $this->headers, $data, $this->options);
                } elseif ($method == self::PUT) {
                    $request = Requests::put($endpoint, $this->headers, $data, $this->options);
                } elseif ($method == self::OPTIONS) {
                    $request = Requests::options($endpoint, $this->headers, $data, $this->options);
                } else {
                    $request = Requests::get($endpoint, $this->headers, $this->options);
                }
                $result = isset($request->body) ? $request->body : $request;
            }
            catch (\Exception $e) {
                $result = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Message: ' . $e->getMessage();
            }
        }
        $this->debug->info(__FUNCTION__, 'Final Result from Request: ' . json_encode($result));

        return $result;
    }
}
