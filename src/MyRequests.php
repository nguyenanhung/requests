<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 03:44
 */

namespace nguyenanhung\MyRequests;

use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\MyRequests\Interfaces\ProjectInterface;
use nguyenanhung\MyRequests\Interfaces\SendRequestsInterface;
use GuzzleHttp\Client;
use Curl\Curl;

/**
 * Class MyRequests
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class MyRequests implements ProjectInterface, SendRequestsInterface
{
    /**
     * An array of headers to be added to the request
     *
     * @var array
     */
    private $headers = [];

    /**
     * An array of cookies (which are added to the headers)
     *
     * @var array
     */
    private $cookies = [];

    /**
     * An array of options to be added to the request
     *
     * @var array
     */
    private $options = [];

    /**
     * How long to wait for a server to respond to a  request.
     *
     * @var integer
     */
    private $timeout = 60;

    /**
     * An array of userAgent to be added to the request
     *
     * @var array|string
     */
    private $userAgent;

    /**
     * An URL String referrer to be added to the request
     *
     * @var string
     */
    private $referrer;

    /**
     * An array of basicAuthentication: username, password to be added to the request
     *
     * @var array
     */
    private $basicAuthentication;

    /**
     * An array of digestAuthentication: username, password to be added to the request
     *
     * @var array
     */
    private $digestAuthentication;

    /**
     * Set data request is Body
     *
     * @var bool
     */
    private $isBody;

    /**
     * Set data request is Json
     *
     * @var bool
     */
    private $isJson;

    /**
     * Set data request is XML
     *
     * @var bool
     */
    private $isXml;

    /**
     * Set data request is SSL
     *
     * @var bool
     */
    private $isSSL = FALSE;

    /**
     * Set Response Error is Array Data
     *
     * @var bool
     */
    private $errorResponseIsData = FALSE;

    /**
     * Set Response Error is Null
     *
     * @var bool
     */
    private $errorResponseIsNull = FALSE;

    /**
     * Error Code from Request
     *
     * @var integer
     */
    private $error_code;

    /**
     * Request Header array if exists, Null if not
     *
     * @var array|null
     */
    private $requests_header;

    /**
     * Response Header array if exists, Null if not
     *
     * @var array|null
     */
    private $response_header;

    /**
     * Http Code from Request
     *
     * @var integer
     */
    private $http_code;

    /**
     * Http Message from Request
     *
     * @var string|null
     */
    private $http_message;

    /**
     * @var object \nguyenanhung\MyDebug\Benchmark
     */
    private $benchmark;
    /**
     * @var  object \nguyenanhung\MyDebug\Debug Call to class
     */
    private $debug;
    /**
     * Set Debug Status
     *
     * @var bool
     */
    public $debugStatus = FALSE;

    /**
     * @var null Set level Debug: DEBUG, INFO, ERROR ....
     */
    public $debugLevel = NULL;

    /**
     * Set Logger Path to Save
     *
     * @var null|string
     */
    public $debugLoggerPath = NULL;

    /**
     * Set Logger Filename to Save
     *
     * @var string
     */
    public $debugLoggerFilename;

    /**
     * MyRequests constructor.
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
        $this->debug->debug(__FUNCTION__, '/-------------------------> Begin Logger - My Requests - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
    }

    /**
     * MyRequests destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark->mark('code_end');
            $this->debug->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->debug->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
        $this->debug->debug(__FUNCTION__, '/-------------------------> End Logger - My Requests - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:46
     *
     * @return mixed|string Current Project version
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
     *
     * @return  $this
     */
    public function setHeader($headers = [])
    {
        $this->headers = $headers;
        $this->debug->info(__FUNCTION__, 'setHeaders: ', $this->headers);

        return $this;
    }

    /**
     * Function setCookie
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:28
     *
     * @param array $cookies
     *
     * @return  $this
     */
    public function setCookie($cookies = [])
    {
        $this->cookies = $cookies;
        $this->debug->info(__FUNCTION__, 'setCookie: ', $this->cookies);

        return $this;
    }

    /**
     * Function setOptions
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 04:04
     *
     * @param array $options
     *
     * @return  $this
     */
    public function setOptions($options = [])
    {
        $this->options = $options;
        $this->debug->info(__FUNCTION__, 'setOptions: ', $this->options);

        return $this;
    }

    /**
     * Function setTimeout
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 04:05
     *
     * @param int $timeout
     *
     * @return  $this
     */
    public function setTimeout($timeout = 60)
    {
        $this->timeout = $timeout;
        $this->debug->info(__FUNCTION__, 'setTimeout: ', $this->timeout);

        return $this;
    }

    /**
     * Function setUserAgent
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:19
     *
     * @param string $userAgent
     *
     * @return  $this
     */
    public function setUserAgent($userAgent = '')
    {
        $this->userAgent = $userAgent;
        $this->debug->info(__FUNCTION__, 'setUserAgent: ', $this->userAgent);

        return $this;
    }

    /**
     * Function setReferrer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:26
     *
     * @param string $referrer
     *
     * @return  $this
     */
    public function setReferrer($referrer = '')
    {
        $this->referrer = $referrer;
        $this->debug->info(__FUNCTION__, 'setReferrer: ', $this->referrer);

        return $this;
    }

    /**
     * Function setUserBody
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:25
     *
     * @param bool $isBody
     *
     * @return  $this
     */
    public function setUserBody($isBody = FALSE)
    {
        $this->isBody = $isBody;
        $this->debug->info(__FUNCTION__, 'setUserBody: ', $this->referrer);

        return $this;
    }

    /**
     * Function setRequestIsXml
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:17
     *
     * @param bool $isXml
     *
     * @return  $this
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

        return $this;
    }

    /**
     * Function setRequestIsJson
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:17
     *
     * @param bool $isJson
     *
     * @return  $this
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

        return $this;
    }

    /**
     * Function setRequestIsSSL
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 20:03
     *
     * @param bool $isSSL
     *
     * @return mixed|$this
     */
    public function setRequestIsSSL($isSSL = FALSE)
    {
        $this->isSSL = $isSSL;
        $this->debug->info(__FUNCTION__, 'setRequestIsSSL: ', $this->isSSL);

        return $this;
    }

    /**
     * Function setErrorResponseIsData
     * = true -> sẽ trả về 1 response đầy đủ error code, error message
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:02
     *
     * @param bool $errorResponseIsData Array Data if Response is Null if Error
     *
     * @return  $this;
     */
    public function setErrorResponseIsData($errorResponseIsData = FALSE)
    {
        $this->errorResponseIsData = $errorResponseIsData;
        $this->debug->info(__FUNCTION__, 'setErrorResponseIsData: ', $this->errorResponseIsData);

        return $this;
    }

    /**
     * Function setErrorResponseIsNull
     * Trả về null nếu có lỗi request
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:04
     *
     * @param bool $errorResponseIsNull TRUE if Response is Null if Error
     *
     * @return mixed|$this
     */
    public function setErrorResponseIsNull($errorResponseIsNull = FALSE)
    {
        $this->errorResponseIsNull = $errorResponseIsNull;
        $this->debug->info(__FUNCTION__, 'setErrorResponseIsNull: ', $this->errorResponseIsNull);

        return $this;
    }

    /**
     * Function setBasicAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:24
     *
     * @param string $username Username to be Authentication
     * @param string $password Password to be Authentication
     *
     * @return  $this
     */
    public function setBasicAuthentication($username = '', $password = '')
    {
        $this->basicAuthentication = [
            'username' => $username,
            'password' => $password
        ];
        $this->debug->info(__FUNCTION__, 'setBasicAuthentication: ', $this->basicAuthentication);

        return $this;
    }

    /**
     * Function setDigestAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:28
     *
     * @param string $username Username to be Authentication
     * @param string $password Password to be Authentication
     *
     * @return  $this
     */
    public function setDigestAuthentication($username = '', $password = '')
    {
        $this->digestAuthentication = [$username, $password, 'digest'];
        $this->debug->info(__FUNCTION__, 'setDigestAuthentication: ', $this->digestAuthentication);

        return $this;
    }

    /**
     * Function getHttpCode
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:16
     *
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->http_code;
    }

    /**
     * Function getHttpMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:16
     *
     * @return mixed
     */
    public function getHttpMessage()
    {
        return $this->http_message;
    }

    /**
     * Function getErrorCode
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:16
     *
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * Function getRequestsHeader
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:16
     *
     * @return mixed
     */
    public function getRequestsHeader()
    {
        return $this->requests_header;
    }

    /**
     * Function getResponseHeader
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:16
     *
     * @return mixed
     */
    public function getResponseHeader()
    {
        return $this->response_header;
    }

    /******************************** Các hàm Request ********************************/

    /**
     * Function guzzlePhpRequest
     * Send Request use GuzzleHttp\Client - https://packagist.org/packages/guzzlehttp/guzzle
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:45
     *
     * @param string $url    URL Endpoint to be Request
     * @param array  $data   Data Content to be Request
     * @param string $method Set Method to be Request
     *
     * @return \GuzzleHttp\Stream\StreamInterface|null|string
     * @see   https://packagist.org/packages/guzzlehttp/guzzle
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
                // Debug
                $status_code        = $request->getStatusCode();
                $status_message     = $request->getReasonPhrase();
                $http_error         = in_array(floor($this->http_code / 100), [4, 5]);
                $error_code         = [
                    'status'        => $status_code,
                    'error'         => $status_code,
                    'error_code'    => $status_code,
                    'error_message' => $status_message,
                    'http_error'    => [
                        'http_error'         => $http_error,
                        'http_status_code'   => $status_code,
                        'http_error_message' => $status_message
                    ],
                    'headers'       => [
                        'request_headers'  => $this->headers,
                        'response_headers' => $request->getHeaders(),
                    ],
                    'data'          => [
                        'status'           => $request->getStatusCode(),
                        'error_code'       => $request->getStatusCode(),
                        'error_message'    => $request->getReasonPhrase(),
                        'reasonPhrase'     => $request->getReasonPhrase(),
                        'effectiveUrl'     => $request->getEffectiveUrl(),
                        'protocolVersion'  => $request->getProtocolVersion(),
                        'headers'          => $request->getHeaders(),
                        'requests_url'     => $endpoint,
                        'requests_options' => $this->options,
                        'response_body'    => $request->getBody()
                    ]
                ];
                $this->http_code    = $status_code;
                $this->http_message = $request->getReasonPhrase();
                $this->error_code   = $error_code;
                $this->debug->debug(__FUNCTION__, 'Full Data Curl Message and Http Message: ', $error_code);
                if ($http_error) {
                    if ($this->errorResponseIsData === TRUE) {
                        $this->debug->debug(__FUNCTION__, 'Return Error Response is Array Data');
                        $result = $error_code;
                    } elseif ($this->errorResponseIsNull === TRUE) {
                        $this->debug->debug(__FUNCTION__, 'Return Error Response is Null');
                        $result = NULL;
                    } else {
                        $result = $request;
                        $this->debug->debug(__FUNCTION__, 'Return Error Response is Message: ' . $result);
                    }
                } else {
                    $result = $request->getBody();
                }
            }
            catch (\Exception $e) {
                $result = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
                $this->debug->error(__FUNCTION__, 'Exception Error - ' . $result);
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
     * @param string $url    URL Endpoint to be Request
     * @param array  $data   Data Content to be Request
     * @param string $method Set Method to be Request
     *
     * @return array|null|string Response content from server,
     *                           null of Exception Message if Error
     * @see   https://packagist.org/packages/curl/curl
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
        if (!class_exists('Curl\Curl')) {
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
                        $curl->setHeader($key, $value);
                    }
                }
                if (is_array($this->cookies) && count($this->cookies) > 0) {
                    foreach ($this->cookies as $key => $value) {
                        $curl->setCookie($key, $value);
                    }
                }
                if ($this->basicAuthentication) {
                    $curl->setBasicAuthentication($this->basicAuthentication['username'], $this->basicAuthentication['password']);
                }
                if ($this->referrer) {
                    $curl->setReferer($this->referrer);
                }
                $curl->setOpt(CURLOPT_RETURNTRANSFER, self::RETURN_TRANSFER);
                $curl->setOpt(CURLOPT_SSL_VERIFYPEER, $this->isSSL);
                $curl->setOpt(CURLOPT_SSL_VERIFYHOST, $this->isSSL);
                $curl->setOpt(CURLOPT_ENCODING, self::ENCODING);
                $curl->setOpt(CURLOPT_MAXREDIRS, self::MAX_REDIRECT);
                $curl->setOpt(CURLOPT_TIMEOUT, $this->timeout);
                $curl->setOpt(CURLOPT_CONNECTTIMEOUT, $this->timeout);
                $curl->setOpt(CURLOPT_FOLLOWLOCATION, self::FOLLOW_LOCATION);
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
                } elseif (self::OPTIONS == $method) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::OPTIONS . ' request to ' . $url . ' with Data: ', $data);
                    $curl->options($url, $data);
                } elseif (self::HEAD == $method) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::HEAD . ' request to ' . $url . ' with Data: ', $data);
                    $curl->head($url, $data);
                } elseif (self::GET == $method) {
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::GET . ' request to ' . $url . ' with Data: ', $data);
                    $curl->get($url, $data);
                } else {
                    $this->debug->debug(__FUNCTION__, 'Make DEFAULT request to ' . $url . ' with Data: ', $data);
                    $curl->get($url, $data);
                }
                // Response
                if (($curl->error)) {
                    $error_code = [
                        'status'        => $curl->errorCode,
                        'error'         => $curl->error,
                        'error_code'    => $curl->errorCode,
                        'error_message' => $curl->errorMessage,
                        'curl_error'    => [
                            'curl_error'         => $curl->curlError,
                            'curl_error_code'    => $curl->curlErrorCode,
                            'curl_error_message' => $curl->curlErrorMessage
                        ],
                        'http_error'    => [
                            'http_error'         => $curl->httpError,
                            'http_status_code'   => $curl->httpStatusCode,
                            'http_error_message' => $curl->httpErrorMessage
                        ],
                        'headers'       => [
                            'request_headers'  => $curl->requestHeaders,
                            'response_headers' => $curl->responseHeaders,
                        ]
                    ];
                    // Set Vars
                    $this->error_code      = $error_code;
                    $this->http_code       = $curl->httpStatusCode;
                    $this->http_message    = $curl->httpErrorMessage;
                    $this->requests_header = $curl->requestHeaders;
                    $this->response_header = $curl->rawResponseHeaders;
                    // Debug
                    $this->debug->debug(__FUNCTION__, 'Full Data Curl Message and Http Message: ', $error_code);
                    if ($this->errorResponseIsData === TRUE) {
                        $this->debug->debug(__FUNCTION__, 'Return Error Response is Array Data');
                        $response = $error_code;
                    } elseif ($this->errorResponseIsNull === TRUE) {
                        $this->debug->debug(__FUNCTION__, 'Return Error Response is Null');
                        $response = NULL;
                    } else {
                        $response = "cURL Error: " . $curl->errorMessage;
                        $this->debug->debug(__FUNCTION__, 'Return Error Response is Message: ' . $response);
                    }
                } else {
                    $response = $curl->rawResponse;
                    $this->debug->debug(__FUNCTION__, 'Response from Request, no Error: ' . $response);
                }
                // Close Request
                $curl->close();
                // Log Response
                if (isset($response)) {
                    $this->debug->info(__FUNCTION__, 'Final Result from Request: ', $response);
                }
            }
            catch (\Exception $e) {
                $response = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
                $this->debug->error(__FUNCTION__, 'Exception Error - ' . $response);
            }
        }

        return $response;
    }

    /******************************** Handle Send Request ********************************/
    /**
     * Function sendRequest
     * Handle send Request use Multi Method
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:07
     *
     *
     * @param string $url    URL Endpoint to be Request
     * @param array  $data   Data Content to be Request
     * @param string $method Set Method to be Request
     *
     * @return array|\GuzzleHttp\Stream\StreamInterface|string|null Response content from server
     *                                              null of Exception Message if Error
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
                    // Handle GET Request with curlRequest
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::GET . ' request to ' . $url . ' with Data: ', $data);
                    $result = $this->curlRequest($url, $data, $method);
                } elseif ($method == self::HEAD) {
                    // Handle HEAD Request with pyRequest
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::HEAD . ' request to ' . $url . ' with Data: ', $data);
                    $result = $this->guzzlePhpRequest($url, $data, $method);
                } elseif ($method == self::DELETE) {
                    // Handle DELETE Request with curlRequest
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::DELETE . ' request to ' . $url . ' with Data: ', $data);
                    $result = $this->curlRequest($url, $data, $method);
                } elseif ($method == self::TRACE) {
                    // Handle TRACE Request with pyRequest
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::TRACE . ' request to ' . $url . ' with Data: ', $data);
                    $result = $this->guzzlePhpRequest($url, $data, $method);
                } elseif ($method == self::POST) {
                    // Handle POST Request with curlRequest
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::POST . ' request to ' . $url . ' with Data: ', $data);
                    $result = $this->curlRequest($url, $data, $method);
                } elseif ($method == self::PUT) {
                    // Handle PUT Request with curlRequest
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::PUT . ' request to ' . $url . ' with Data: ', $data);
                    $result = $this->curlRequest($url, $data, $method);
                } elseif ($method == self::OPTIONS) {
                    // Handle OPTIONS Request with pyRequest
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::OPTIONS . ' request to ' . $url . ' with Data: ', $data);
                    $result = $this->guzzlePhpRequest($url, $data, $method);
                } elseif ($method == self::PATCH) {
                    // Handle PATCH Request with curlRequest
                    $this->debug->debug(__FUNCTION__, 'Make ' . self::PATCH . ' request to ' . $url . ' with Data: ', $data);
                    $result = $this->curlRequest($url, $data, $method);
                } else {
                    // Handle DEFAULT Request with curlRequest
                    $this->debug->debug(__FUNCTION__, 'Make DEFAULT request to ' . $url . ' with Data: ', $data);
                    $result = $this->curlRequest($url, $data, $method);
                }
            }
            catch (\Exception $e) {
                $result = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
                $this->debug->error(__FUNCTION__, $result);
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
     * @param string $url     URL Endpoint to be Request
     * @param string $data    Data Content to be Request
     * @param int    $timeout Timeout Request
     *
     * @return array|null|string Response from Server
     */
    public function xmlRequest($url = '', $data = '', $timeout = 60)
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
     * @param string $url     URL Endpoint to be Request
     * @param array  $data    Data Content to be Request
     * @param int    $timeout Timeout Request
     *
     * @return array|null|string Response from Server
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

    /******************************** Utils Function ********************************/
    /**
     * Function xmlGetValue
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:57
     *
     * @param string $xml      XML String
     * @param string $openTag  OpenTag to find
     * @param string $closeTag CloseTag to find
     *
     * @return bool|string  Result from Tag, Empty string if not
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
     * @param string $resultXml XML String to Parse
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
