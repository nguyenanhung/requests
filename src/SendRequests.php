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
    private $cookies         = [];
    private $options         = [];
    private $timeout         = 60;
    private $userAgent;
    private $referrer;
    private $basicAuthentication;
    private $isJson;
    private $isXml;
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
    public function setHeader($headers = [])
    {
        $this->headers = $headers;
        var_dump($this->debug->info(__FUNCTION__, 'setHeaders: ', $this->headers));
    }

    /**
     * Function setCookie
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:28
     *
     * @param array $cookies
     */
    public function setCookie($cookies = [])
    {
        $this->cookies = $cookies;
        var_dump($this->debug->info(__FUNCTION__, 'setCookie: ', $this->cookies));
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
     * Function setUserAgent
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:19
     *
     * @param string $userAgent
     */
    public function setUserAgent($userAgent = '')
    {
        $this->userAgent = $userAgent;
        $this->debug->info(__FUNCTION__, 'setUserAgent: ', $this->userAgent);
    }

    /**
     * Function setReferrer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:26
     *
     * @param string $referrer
     */
    public function setReferrer($referrer = '')
    {
        $this->referrer = $referrer;
        $this->debug->info(__FUNCTION__, 'setReferrer: ', $this->referrer);
    }

    /**
     * Function setRequestIsXml
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:17
     *
     * @param bool $isXml
     */
    public function setRequestIsXml($isXml = FALSE)
    {
        $this->isXml = $isXml;
        if ($this->isXml === TRUE) {
            $header['Accept']       = 'text/xml; charset=utf-8';
            $header['Content-type'] = 'text/xml; charset=utf-8';
            $this->headers          = $header;
        }
        $this->debug->info(__FUNCTION__, 'setRequestIsXml: ', $this->isXml);
    }

    /**
     * Function setRequestIsJson
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:17
     *
     * @param bool $isJson
     */
    public function setRequestIsJson($isJson = FALSE)
    {
        $this->isJson = $isJson;
        if ($this->isJson === TRUE) {
            $header['Accept']       = 'application/json; charset=utf-8';
            $header['Content-type'] = 'application/json; charset=utf-8';
            $this->headers          = $header;
        }
        $this->debug->info(__FUNCTION__, 'setRequestIsJson: ', $this->isJson);
    }

    /**
     * Function setBasicAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:24
     *
     * @param string $username
     * @param string $password
     */
    public function setBasicAuthentication($username = '', $password = '')
    {
        $this->basicAuthentication = [
            'username' => $username,
            'password' => $password
        ];
        $this->debug->info(__FUNCTION__, 'setBasicAuthentication: ', $this->basicAuthentication);
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
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::GET . ' request to ' . $url . ' with Data: ', $data);
                    $request = Requests::get($endpoint, $this->headers, $this->options);
                } elseif ($method == self::HEAD) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::HEAD . ' request to ' . $url . ' with Data: ', $data);
                    $request = Requests::head($endpoint, $this->headers, $this->options);
                } elseif ($method == self::DELETE) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::DELETE . ' request to ' . $url . ' with Data: ', $data);
                    $request = Requests::delete($endpoint, $this->headers, $this->options);
                } elseif ($method == self::TRACE) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::TRACE . ' request to ' . $url . ' with Data: ', $data);
                    $request = Requests::trace($endpoint, $this->headers, $this->options);
                } elseif ($method == self::POST) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::POST . ' request to ' . $url . ' with Data: ', $data);
                    $request = Requests::post($endpoint, $this->headers, $data, $this->options);
                } elseif ($method == self::PUT) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::PUT . ' request to ' . $url . ' with Data: ', $data);
                    $request = Requests::put($endpoint, $this->headers, $data, $this->options);
                } elseif ($method == self::OPTIONS) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::OPTIONS . ' request to ' . $url . ' with Data: ', $data);
                    $request = Requests::options($endpoint, $this->headers, $data, $this->options);
                } else {
                    $this->debug->debug(__FUNCTION__, 'Make DEFAULT request to ' . $url . ' with Data: ', $data);
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

    /**
     * Function curlRequest
     * Send Request with \Curl\Curl class
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:35
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     *
     * @return null|string
     * @throws \ErrorException
     */
    public function curlRequest($url = '', $data = [], $method = 'GET')
    {
        $this->debug->debug(__FUNCTION__, '/---------------------------> ' . __FUNCTION__ . ' <---------------------------\\');
        $inputParams = [
            'url'    => $url,
            'data'   => $data,
            'method' => $method,
        ];
        $this->debug->info(__FUNCTION__, 'input Params: ', $inputParams);
        $method = strtoupper($method);
        if (!class_exists('Requests')) {
            $this->debug->critical(__FUNCTION__, 'class \Curl\Curl() is not exits');
            $response = NULL;
        } else {
            $curl = new Curl();
            if ($this->isJson) {
                $data = json_encode($data);
                $this->debug->info(__FUNCTION__, 'isJson Data: ', $data);
            }
            if ($this->userAgent) {
                $curl->setUserAgent($this->userAgent);
            }
            if (is_array($this->headers) && count($this->headers) > 0) {
                foreach ($this->headers as $key => $value) {
                    $curl->setCookie($key, $value);
                }
            }
            if (is_array($this->cookies) && count($this->cookies) > 0) {
                foreach ($this->cookies as $key => $value) {
                    $curl->setHeader($key, $value);
                }
            }
            if ($this->basicAuthentication) {
                $curl->setBasicAuthentication($this->basicAuthentication['username'], $this->basicAuthentication['password']);
            }
            if ($this->referrer) {
                $curl->setReferer($this->referrer);
            }
            $curl->setOpt(CURLOPT_RETURNTRANSFER, 1);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);
            $curl->setOpt(CURLOPT_ENCODING, self::ENCODING);
            $curl->setOpt(CURLOPT_MAXREDIRS, self::MAX_REDIRECT);
            $curl->setOpt(CURLOPT_TIMEOUT, $this->timeout);
            $curl->setOpt(CURLOPT_CONNECTTIMEOUT, $this->timeout);
            $curl->setOpt(CURLOPT_FOLLOWLOCATION, TRUE);
            // Request
            if (self::POST == $method) {
                $this->debug->debug(__FUNCTION__, 'Make ' . self::POST . ' request to ' . $url . ' with Data: ', $data);
                $curl->post($url, $data);
            } elseif (self::PUT == $method) {
                $this->debug->debug(__FUNCTION__, 'Make ' . self::PUT . ' request to ' . $url . ' with Data: ', $data);
                $curl->put($url, $data);
            } elseif (self::PATCH == $method) {
                $this->debug->debug(__FUNCTION__, 'Make ' . self::PATCH . ' request to ' . $url . ' with Data: ', $data);
                $curl->patch($url, $data);
            } elseif (self::DELETE == $method) {
                $this->debug->debug(__FUNCTION__, 'Make ' . self::DELETE . ' request to ' . $url . ' with Data: ', $data);
                $curl->delete($url, $data);
            } elseif (self::GET == $method) {
                $this->debug->debug(__FUNCTION__, 'Make ' . self::GET . ' request to ' . $url . ' with Data: ', $data);
                $curl->get($url, $data);
            } else {
                $this->debug->debug(__FUNCTION__, 'Make DEFAULT request to ' . $url . ' with Data: ', $data);
                $curl->get($url, $data);
            }
            // Response
            if (($curl->error)) {
                $response = "cURL Error: " . $curl->error_message;
            } else {
                $response = $curl->response;
            }
            // Close Request
            $curl->close();
            // Log Response
            $this->debug->info('Response: ', $response);
            if (isset($curl->request_headers)) {
                $this->debug->info('Request Header: ', $curl->request_headers);
            }
            if (isset($curl->response_headers)) {
                $this->debug->info('Response Header: ', $curl->response_headers);
            }
        }

        return $response;
    }
}
