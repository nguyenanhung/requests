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

class MyRequests implements ProjectInterface, SendRequestsInterface
{
    private $headers         = [];
    private $cookies         = [];
    private $options         = [];
    private $timeout         = 60;
    private $userAgent;
    private $referrer;
    private $basicAuthentication;
    private $digestAuthentication;
    private $isBody;
    private $isJson;
    private $isXml;
    private $debug;
    public  $debugStatus     = FALSE;
    public  $debugLoggerPath = NULL;
    public  $debugLoggerFilename;

    /**
     * MyRequests constructor.
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
        $this->debug->debug(__FUNCTION__, '/------------------------------------> Send Requests <------------------------------------\\');
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
        $this->debug->info(__FUNCTION__, 'setHeaders: ', $this->headers);
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
        $this->debug->info(__FUNCTION__, 'setCookie: ', $this->cookies);
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
     * Function setUserBody
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:25
     *
     * @param bool $isBody
     */
    public function setUserBody($isBody = FALSE)
    {
        $this->isBody = $isBody;
        $this->debug->info(__FUNCTION__, 'setUserBody: ', $this->referrer);
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
     * Function setDigestAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:28
     *
     * @param string $username
     * @param string $password
     */
    public function setDigestAuthentication($username = '', $password = '')
    {
        $this->digestAuthentication = [$username, $password, 'digest'];
        $this->debug->info(__FUNCTION__, 'setDigestAuthentication: ', $this->digestAuthentication);
    }

    /**
     * Function pyRequest
     * Send Request use Requests - https://packagist.org/packages/rmccue/requests
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
        $this->debug->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $inputParams = [
            'url'    => $url,
            'data'   => $data,
            'method' => $method,
        ];
        $this->debug->info(__FUNCTION__, 'input Params: ', $inputParams);
        $method = strtoupper($method);
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            return $this->curlRequest($url, $data, $method);
        }
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
                } elseif ($method == self::PATCH) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::PATCH . ' request to ' . $url . ' with Data: ', $data);
                    $request = Requests::patch($endpoint, $this->headers, $data, $this->options);
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
        $this->debug->info(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }

    /**
     * Function guzzlePhpRequest
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:45
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     *
     * @return \GuzzleHttp\Stream\StreamInterface|null|string
     */
    public function guzzlePhpRequest($url = '', $data = [], $method = 'GET')
    {
        $this->debug->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $inputParams = [
            'url'    => $url,
            'data'   => $data,
            'method' => $method,
        ];
        $this->debug->info(__FUNCTION__, 'input Params: ', $inputParams);
        $method   = strtoupper($method);
        $endpoint = trim($url);
        $this->debug->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            return $this->curlRequest($url, $data, $method);
        }
        if (!class_exists('GuzzleHttp\Client')) {
            $this->debug->critical(__FUNCTION__, 'class GuzzleHttp\Client is not exits');
            $result = NULL;
        } else {
            try {
                $client = new Client();
                // Create options
                $options = [
                    'timeout'         => $this->timeout,
                    'connect_timeout' => $this->timeout,
                ];
                if (is_array($this->headers) && count($this->headers) > 0) {
                    $options = [
                        'headers' => $this->headers
                    ];
                }
                if (is_array($this->cookies) && count($this->cookies) > 0) {
                    $options = [
                        'cookies' => $this->cookies
                    ];
                }
                if ($this->basicAuthentication) {
                    $options['auth'] = $this->basicAuthentication;
                }
                if ($this->digestAuthentication) {
                    $options['auth'] = $this->digestAuthentication;
                }
                if (($this->isBody == TRUE) && ($method == self::POST || $method == self::PUT || $method == self::PATCH || $method == self::OPTIONS)) {
                    if ($this->isJson) {
                        $options['body'] = json_encode($data);
                    } else {
                        $options['body'] = $data;
                    }
                } else {
                    $options['query'] = $data;
                }
                $this->setOptions($options);
                if ($method == self::GET) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::GET . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->get($endpoint, $this->options);
                } elseif ($method == self::HEAD) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::HEAD . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->head($endpoint, $this->options);
                } elseif ($method == self::DELETE) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::DELETE . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->delete($endpoint, $this->options);
                } elseif ($method == self::POST) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::POST . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->post($endpoint, $this->options);
                } elseif ($method == self::PUT) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::PUT . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->put($endpoint, $this->options);
                } elseif ($method == self::OPTIONS) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::OPTIONS . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->options($endpoint, $this->options);
                } elseif ($method == self::PATCH) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::PATCH . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->patch($endpoint, $this->options);
                } else {
                    $this->debug->debug(__FUNCTION__, 'Make DEFAULT request to ' . $url . ' with Data: ', $data);
                    $request = $client->get($endpoint, $this->options);
                }
                // Logger
                $result          = $request->getBody();
                $getHeaders      = $request->getHeaders();
                $getStatusCode   = $request->getStatusCode();
                $getEffectiveUrl = $request->getEffectiveUrl();
                $this->debug->debug(__FUNCTION__, 'getBody from Request: ', $result);
                $this->debug->debug(__FUNCTION__, 'getHeaders from Request: ', $getHeaders);
                $this->debug->debug(__FUNCTION__, 'getStatusCode from Request: ', $getStatusCode);
                $this->debug->debug(__FUNCTION__, 'getEffectiveUrl from Request: ', $getEffectiveUrl);
            }
            catch (\Exception $e) {
                $result = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Message: ' . $e->getMessage();
            }
        }
        $this->debug->info(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }

    /**
     * Function curlRequest
     * Send Request use \Curl\Curl class - https://packagist.org/packages/curl/curl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:54
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     *
     * @return null|string
     */
    public function curlRequest($url = '', $data = [], $method = 'GET')
    {
        $this->debug->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
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
            try {
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
                $this->debug->info('Final Result from Request: ', $response);
                $this->debug->debug('Error Code: ', $curl->error_code);
                $this->debug->debug('HTTP Status Code: ', $curl->http_status_code);
                $this->debug->debug('HTTP Error: ', $curl->http_error);
                $this->debug->debug('HTTP Error Message: ', $curl->http_error_message);
                $this->debug->debug('Request Header: ', $curl->request_headers);
                $this->debug->debug('Response Header: ', $curl->response_headers);
            }
            catch (\Exception $e) {
                $response = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Message: ' . $e->getMessage();
            }
        }

        return $response;
    }

    /******************************** Send Request ********************************/
    /**
     * Function sendRequest
     * Make Sending Request
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:07
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     *
     * @return array|null|\Requests_Response|string
     */
    public function sendRequest($url = '', $data = [], $method = 'GET')
    {
        $this->debug->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $inputParams = [
            'url'    => $url,
            'data'   => $data,
            'method' => $method,
        ];
        $this->debug->info(__FUNCTION__, 'input Params: ', $inputParams);
        $method   = strtoupper($method);
        $endpoint = trim($url);
        $this->debug->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        if (!extension_loaded('curl')) {
            $this->debug->critical(__FUNCTION__, 'Server is not Support cURL, Please cURL. Library fallback user File Get Contents');
            // Create Request use File Get Content
            $content                  = new GetContents();
            $content->debugStatus     = $this->debugStatus;
            $content->debugLoggerPath = $this->debugLoggerPath;
            $content->__construct();
            $content->setURL($url);
            $content->setMethod($method);
            $content->setData($data);
            $content->sendRequest();
            // Create Request
            $result     = $content->response();
            $getContent = $content->getContent();
            $getError   = $content->getError();
            $this->debug->debug(__FUNCTION__, 'Get Content Result: ' . $getContent);
            $this->debug->debug(__FUNCTION__, 'Get Error Result: ' . $getError);
        } else {
            try {
                if ($method == self::GET) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::GET . ' request to ' . $url . ' with Data: ', $data);
                    $request = $this->curlRequest($url, $data, $method);
                } elseif ($method == self::HEAD) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::HEAD . ' request to ' . $url . ' with Data: ', $data);
                    $request    = $this->pyRequest($url, $data, $method);
                    $bodyResult = isset($request->body) ? $request->body : $request;
                } elseif ($method == self::DELETE) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::DELETE . ' request to ' . $url . ' with Data: ', $data);
                    $request = $this->curlRequest($url, $data, $method);
                } elseif ($method == self::TRACE) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::TRACE . ' request to ' . $url . ' with Data: ', $data);
                    $request    = $this->pyRequest($url, $data, $method);
                    $bodyResult = isset($request->body) ? $request->body : $request;
                } elseif ($method == self::POST) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::POST . ' request to ' . $url . ' with Data: ', $data);
                    $request = $this->curlRequest($url, $data, $method);
                } elseif ($method == self::PUT) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::PUT . ' request to ' . $url . ' with Data: ', $data);
                    $request = $this->curlRequest($url, $data, $method);
                } elseif ($method == self::OPTIONS) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::OPTIONS . ' request to ' . $url . ' with Data: ', $data);
                    $request    = $this->pyRequest($url, $data, $method);
                    $bodyResult = isset($request->body) ? $request->body : $request;
                } elseif ($method == self::PATCH) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::PATCH . ' request to ' . $url . ' with Data: ', $data);
                    $request = $this->curlRequest($url, $data, $method);
                } else {
                    $this->debug->debug(__FUNCTION__, 'Make DEFAULT request to ' . $url . ' with Data: ', $data);
                    $request = $this->curlRequest($url, $data, $method);
                }
                $result = isset($bodyResult) ? $bodyResult : $request;
            }
            catch (\Exception $e) {
                $result = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Message: ' . $e->getMessage();
            }
        }
        $this->debug->info(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }

    /**
     * Function xmlRequest
     * Send XML Request to Server
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:11
     *
     * @param string $url
     * @param array  $data
     * @param int    $timeout
     *
     * @return array|null|string
     */
    public function xmlRequest($url = '', $data = [], $timeout = 60)
    {
        $this->debug->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $inputParams = [
            'url'     => $url,
            'data'    => $data,
            'timeout' => $timeout,
        ];
        $this->debug->info(__FUNCTION__, 'input Params: ', $inputParams);
        $endpoint = trim($url);
        $this->debug->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        if (!extension_loaded('curl')) {
            $this->debug->critical(__FUNCTION__, 'Server is not Support cURL, Please cURL. Library fallback user File Get Contents');
            // Create Request use File Get Content
            $content                  = new GetContents();
            $content->debugStatus     = $this->debugStatus;
            $content->debugLoggerPath = $this->debugLoggerPath;
            $content->__construct();
            $content->setURL($url);
            $content->setMethod('POST');
            $content->setXML(TRUE);
            $content->setData($data);
            $content->sendRequest();
            // Create Request
            $result     = $content->response();
            $getContent = $content->getContent();
            $getError   = $content->getError();
            $this->debug->debug(__FUNCTION__, 'Get Content Result: ' . $getContent);
            $this->debug->debug(__FUNCTION__, 'Get Error Result: ' . $getError);
        } else {
            $this->setRequestIsXml(TRUE);
            $this->setTimeout($timeout);
            $result = $this->curlRequest($url, $data, 'POST');
        }
        $this->debug->info(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }

    /**
     * Function jsonRequest
     * Send JSON Request to Server
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:13
     *
     * @param string $url
     * @param array  $data
     * @param int    $timeout
     *
     * @return array|null|string
     */
    public function jsonRequest($url = '', $data = [], $timeout = 60)
    {
        $this->debug->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $inputParams = [
            'url'     => $url,
            'data'    => $data,
            'timeout' => $timeout,
        ];
        $this->debug->info(__FUNCTION__, 'input Params: ', $inputParams);
        $endpoint = trim($url);
        $this->debug->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        if (!extension_loaded('curl')) {
            $this->debug->critical(__FUNCTION__, 'Server is not Support cURL, Please cURL. Library fallback user File Get Contents');
            // Create Request use File Get Content
            $content                  = new GetContents();
            $content->debugStatus     = $this->debugStatus;
            $content->debugLoggerPath = $this->debugLoggerPath;
            $content->__construct();
            $content->setURL($url);
            $content->setMethod('POST');
            $content->setJson(TRUE);
            $content->setData($data);
            $content->sendRequest();
            // Create Request
            $result     = $content->response();
            $getContent = $content->getContent();
            $getError   = $content->getError();
            $this->debug->debug(__FUNCTION__, 'Get Content Result: ' . $getContent);
            $this->debug->debug(__FUNCTION__, 'Get Error Result: ' . $getError);
        } else {
            $this->setRequestIsJson(TRUE);
            $this->setTimeout($timeout);
            $result = $this->curlRequest($url, $data, 'POST');
        }
        $this->debug->info(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }
    /******************************** Utils ********************************/
    /**
     * Function xmlGetValue
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:57
     *
     * @param string $xml
     * @param string $openTag
     * @param string $closeTag
     *
     * @return bool|string
     */
    public function xmlGetValue($xml = '', $openTag = '', $closeTag = '')
    {
        if (empty($xml) || empty($openTag) || empty($closeTag)) {
            return '';
        }
        $f = strpos($xml, $openTag) + strlen($openTag);
        $l = strpos($xml, $closeTag);

        return ($f <= $l) ? substr($xml, $f, $l - $f) : "";
    }

    /**
     * Function parseXmlDataRequest
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:57
     *
     * @param string $resultXml
     *
     * @return false|string
     */
    public function parseXmlDataRequest($resultXml = '')
    {
        $array = [
            'ec'  => $this->xmlGetValue($resultXml, "<ec>", "</ec>"),
            'msg' => $this->xmlGetValue($resultXml, "<msg>", "</msg>")
        ];

        return json_encode($array);
    }
}
