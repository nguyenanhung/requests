<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 03:44
 */

namespace nguyenanhung\MyRequests;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
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
    use Version;

    /**
     * An array of headers to be added to the request
     *
     * @var array
     */
    private $headers = array();

    /**
     * An array of cookies (which are added to the headers)
     *
     * @var array
     */
    private $cookies = array();

    /**
     * An array of options to be added to the request
     *
     * @var array
     */
    private $options = array();

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
     * An string of bearerToken to be added to the request
     *
     * @var string
     */
    private $bearerToken;

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
    protected $isXml;

    /**
     * Set data request is SSL
     *
     * @var bool
     */
    private $isSSL = false;

    /**
     * Set Response Error is Array Data
     *
     * @var bool
     */
    private $errorResponseIsData = false;

    /**
     * Set Response Error is Null
     *
     * @var bool
     */
    private $errorResponseIsNull = false;

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
    private $logger;

    /**
     * Set Debug Status
     *
     * @var bool
     */
    public $debugStatus = false;

    /**
     * @var null Set level Debug: DEBUG, INFO, ERROR ....
     */
    public $debugLevel = null;

    /**
     * Set Logger Path to Save
     *
     * @var null|string
     */
    public $debugLoggerPath = null;

    /**
     * Set Logger Filename to Save
     *
     * @var string
     */
    public $debugLoggerFilename;

    /**
     * MyRequests constructor.
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
        $this->logger = new Debug();
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
     * MyRequests destructor.
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
     * Function setHeader
     *
     * @param array $headers
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 09:44
     */
    public function setHeader($headers = array())
    {
        $this->headers = $headers;
        $this->logger->info(__FUNCTION__, 'setHeaders: ', $this->headers);

        return $this;
    }

    /**
     * Function setCookie
     *
     * @param array $cookies
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 09:51
     */
    public function setCookie($cookies = array())
    {
        $this->cookies = $cookies;
        $this->logger->info(__FUNCTION__, 'setCookie: ', $this->cookies);

        return $this;
    }

    /**
     * Function setOptions
     *
     * @param array $options
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 10:00
     */
    public function setOptions($options = array())
    {
        $this->options = $options;
        $this->logger->info(__FUNCTION__, 'setOptions: ', $this->options);

        return $this;
    }

    /**
     * Function setTimeout
     *
     * @param int $timeout
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 10:06
     */
    public function setTimeout($timeout = 60)
    {
        $this->timeout = $timeout;
        $this->logger->info(__FUNCTION__, 'setTimeout: ' . $this->timeout);

        return $this;
    }

    /**
     * Function setUserAgent
     *
     * @param string $userAgent
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 10:15
     */
    public function setUserAgent($userAgent = '')
    {
        $this->userAgent = $userAgent;
        if (is_array($this->userAgent)) {
            $this->logger->info(__FUNCTION__, 'setUserAgent: ', $this->userAgent);
        } else {
            $this->logger->info(__FUNCTION__, 'setUserAgent: ' . $this->userAgent);
        }


        return $this;
    }

    /**
     * Function setReferrer
     *
     * @param string $referrer
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 10:28
     */
    public function setReferrer($referrer = '')
    {
        $this->referrer = $referrer;
        if (is_array($this->referrer)) {
            $this->logger->info(__FUNCTION__, 'setReferrer: ', $this->referrer);
        } else {
            $this->logger->info(__FUNCTION__, 'setReferrer: ' . $this->referrer);
        }

        return $this;
    }

    /**
     * Function setUserBody
     *
     * @param false $isBody
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 11:34
     */
    public function setUserBody($isBody = false)
    {
        $this->isBody = $isBody;
        if (is_array($this->isBody)) {
            $this->logger->info(__FUNCTION__, 'setUserBody: ', $this->isBody);
        } else {
            $this->logger->info(__FUNCTION__, 'setUserBody: ' . $this->isBody);
        }

        return $this;
    }

    /**
     * Function setRequestIsXml
     *
     * @param false $isXml
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 12:00
     */
    public function setRequestIsXml($isXml = false)
    {
        $this->isXml = $isXml;
        if ($this->isXml === true) {
            $header['Accept']       = 'text/xml; charset=utf-8';
            $header['Content-type'] = 'text/xml; charset=utf-8';
            $this->headers          = $header;
        }
        $this->logger->info(__FUNCTION__, 'setRequestIsXml: ' . $this->isXml);

        return $this;
    }

    /**
     * Function setRequestIsJson
     *
     * @param false $isJson
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 12:31
     */
    public function setRequestIsJson($isJson = false)
    {
        $this->isJson = $isJson;
        if ($this->isJson === true) {
            $header['Accept']       = 'application/json; charset=utf-8';
            $header['Content-type'] = 'application/json; charset=utf-8';
            $this->headers          = $header;
        }
        $this->logger->info(__FUNCTION__, 'setRequestIsJson: ' . $this->isJson);

        return $this;
    }

    /**
     * Function setRequestIsSSL
     *
     * @param false $isSSL
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 12:38
     */
    public function setRequestIsSSL($isSSL = false)
    {
        $this->isSSL = $isSSL;
        $this->logger->info(__FUNCTION__, 'setRequestIsSSL: ', $this->isSSL);

        return $this;
    }

    /**
     * Function setErrorResponseIsData
     * = true -> sẽ trả về 1 response đầy đủ error code, error message
     *
     * @param bool $errorResponseIsData Array Data if Response is Null if Error
     *
     * @return  $this;
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:02
     *
     */
    public function setErrorResponseIsData($errorResponseIsData = false)
    {
        $this->errorResponseIsData = $errorResponseIsData;
        $this->logger->info(__FUNCTION__, 'setErrorResponseIsData: ' . $this->errorResponseIsData);

        return $this;
    }

    /**
     * Function setErrorResponseIsNull
     * Trả về null nếu có lỗi request
     *
     * @param bool $errorResponseIsNull TRUE if Response is Null if Error
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:04
     *
     */
    public function setErrorResponseIsNull($errorResponseIsNull = false)
    {
        $this->errorResponseIsNull = $errorResponseIsNull;
        $this->logger->info(__FUNCTION__, 'setErrorResponseIsNull: ' . $this->errorResponseIsNull);

        return $this;
    }

    /**
     * Function setBasicAuthentication
     *
     * @param string $username Username to be Authentication
     * @param string $password Password to be Authentication
     *
     * @return  $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:24
     *
     */
    public function setBasicAuthentication($username = '', $password = '')
    {
        $this->basicAuthentication = [
            'username' => $username,
            'password' => $password
        ];
        $this->logger->info(__FUNCTION__, 'setBasicAuthentication: ', $this->basicAuthentication);

        return $this;
    }

    /**
     * Function setBearerToken
     *
     * @param string $bearerToken String BearerToken for Request
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/04/2021 18:11
     */
    public function setBearerToken($bearerToken = '')
    {
        $this->bearerToken = $bearerToken;
        $this->logger->info(__FUNCTION__, 'setBasicAuthentication: ', $this->basicAuthentication);

        return $this;
    }

    /**
     * Function setDigestAuthentication
     *
     * @param string $username Username to be Authentication
     * @param string $password Password to be Authentication
     *
     * @return  $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:28
     *
     */
    public function setDigestAuthentication($username = '', $password = '')
    {
        $this->digestAuthentication = [$username, $password, 'digest'];
        $this->logger->info(__FUNCTION__, 'setDigestAuthentication: ', $this->digestAuthentication);

        return $this;
    }

    /**
     * Function getHttpCode
     *
     * @return int
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:11
     */
    public function getHttpCode()
    {
        return $this->http_code;
    }

    /**
     * Function getHttpMessage
     *
     * @return string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:09
     */
    public function getHttpMessage()
    {
        return $this->http_message;
    }

    /**
     * Function getErrorCode
     *
     * @return int
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:06
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * Function getRequestsHeader
     *
     * @return array|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:04
     */
    public function getRequestsHeader()
    {
        return $this->requests_header;
    }

    /**
     * Function getResponseHeader
     *
     * @return array|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:01
     */
    public function getResponseHeader()
    {
        return $this->response_header;
    }

    /**
     * Function guzzlePhpRequest
     * Send Request use GuzzleHttp\Client - https://packagist.org/packages/guzzlehttp/guzzle
     *
     * @param string $url    URL Endpoint to be Request
     * @param array  $data   Data Content to be Request
     * @param string $method Set Method to be Request
     *
     * @return array|\Psr\Http\Message\ResponseInterface|\Psr\Http\Message\StreamInterface|string|null
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 06:45
     *
     * @see       https://packagist.org/packages/guzzlehttp/guzzle
     */
    public function guzzlePhpRequest($url = '', $data = array(), $method = 'GET')
    {
        $this->logger->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $inputParams = array('url' => $url, 'data' => $data, 'method' => $method);
        $this->logger->debug(__FUNCTION__, 'input Params: ', $inputParams);
        $method   = strtoupper($method);
        $endpoint = trim($url);
        $this->logger->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            return $this->curlRequest($url, $data, $method);
        }
        if (!class_exists('GuzzleHttp\Client')) {
            $this->logger->critical(__FUNCTION__, 'class GuzzleHttp\Client is not exits');
            $result = null;
        } else {
            try {
                $client = new Client();
                // Create options
                $options = array(
                    'timeout'         => $this->timeout,
                    'connect_timeout' => $this->timeout
                );
                if (is_array($this->headers) && count($this->headers) > 0) {
                    $options['headers'] = $this->headers;
                }
                if (is_array($this->cookies) && count($this->cookies) > 0) {
                    $options['cookies'] = $this->cookies;
                }
                if ($this->basicAuthentication) {
                    $options['auth'] = $this->basicAuthentication;
                }
                if ($this->digestAuthentication) {
                    $options['auth'] = $this->digestAuthentication;
                }
                if ($this->bearerToken) {
                    $options['headers'] = [
                        'Authorization' => 'Bearer ' . $this->bearerToken
                    ];
                }
                if (($this->isBody == true) && ($method == self::POST || $method == self::PUT || $method == self::PATCH || $method == self::OPTIONS)) {
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
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::GET . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->get($endpoint, $this->options);
                } elseif ($method == self::HEAD) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::HEAD . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->head($endpoint, $this->options);
                } elseif ($method == self::DELETE) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::DELETE . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->delete($endpoint, $this->options);
                } elseif ($method == self::POST) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::POST . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->post($endpoint, $this->options);
                } elseif ($method == self::PUT) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::PUT . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->put($endpoint, $this->options);
                } elseif ($method == self::PATCH) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::PATCH . ' request to ' . $url . ' with Data: ', $data);
                    $request = $client->patch($endpoint, $this->options);
                } else {
                    $this->logger->debug(__FUNCTION__, 'Make DEFAULT request to ' . $url . ' with Data: ', $data);
                    $request = $client->get($endpoint, $this->options);
                }
                // Debug
                $status_code        = $request->getStatusCode();
                $status_message     = $request->getReasonPhrase();
                $http_error         = in_array(floor($this->http_code / 100), [4, 5]);
                $error_code         = array(
                    'status'        => $status_code,
                    'error'         => $status_code,
                    'error_code'    => $status_code,
                    'error_message' => $status_message,
                    'http_error'    => array(
                        'http_error'         => $http_error,
                        'http_status_code'   => $status_code,
                        'http_error_message' => $status_message
                    ),
                    'headers'       => array(
                        'request_headers'  => $this->headers,
                        'response_headers' => $request->getHeaders()
                    ),
                    'data'          => array(
                        'status'           => $request->getStatusCode(),
                        'error_code'       => $request->getStatusCode(),
                        'error_message'    => $request->getReasonPhrase(),
                        'reasonPhrase'     => $request->getReasonPhrase(),
                        'protocolVersion'  => $request->getProtocolVersion(),
                        'headers'          => $request->getHeaders(),
                        'requests_url'     => $endpoint,
                        'requests_options' => $this->options,
                        'response_body'    => $request->getBody()
                    )
                );
                $this->http_code    = $status_code;
                $this->http_message = $request->getReasonPhrase();
                $this->error_code   = $error_code;
                $this->logger->debug(__FUNCTION__, 'Full Data Curl Message and Http Message: ', $error_code);
                if ($http_error) {
                    if ($this->errorResponseIsData === true) {
                        $this->logger->debug(__FUNCTION__, 'Return Error Response is Array Data');
                        $result = $error_code;
                    } elseif ($this->errorResponseIsNull === true) {
                        $this->logger->debug(__FUNCTION__, 'Return Error Response is Null');
                        $result = null;
                    } else {
                        $result = $request;
                        $this->logger->debug(__FUNCTION__, 'Return Error Response is Message: ' . json_encode($result));
                    }
                } else {
                    $result = $request->getBody();
                }
            } catch (GuzzleException $exception) {
                $result = "Error File: " . $exception->getFile() . ' - Line: ' . $exception->getLine() . ' Code: ' . $exception->getCode() . ' - Message: ' . $exception->getMessage();
                $this->logger->error(__FUNCTION__, 'Error Message: ' . $exception->getMessage());
                $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $exception->getTraceAsString());
            } catch (Exception $e) {
                $result = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
                $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
                $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());
            }
        }
        $this->logger->debug(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }

    /**
     * Function curlRequest
     * Send Request use \Curl\Curl class - https://packagist.org/packages/curl/curl
     *
     * @param string $url    URL Endpoint to be Request
     * @param array  $data   Data Content to be Request
     * @param string $method Set Method to be Request
     *
     * @return array|null|string Response content from server,
     *                           null of Exception Message if Error
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 05:54
     *
     * @see   https://packagist.org/packages/php-curl-class/php-curl-class
     */
    public function curlRequest($url = '', $data = array(), $method = 'GET')
    {
        $this->logger->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $inputParams = array('url' => $url, 'data' => $data, 'method' => $method);
        $this->logger->info(__FUNCTION__, 'input Params: ', $inputParams);
        $method = strtoupper($method);
        if (!class_exists('Curl\Curl')) {
            $this->logger->critical(__FUNCTION__, 'class \Curl\Curl() is not exits');
            $response = null;
        } else {
            try {
                $curl = new Curl();
                if ($this->isJson) {
                    $data = json_encode($data);
                    $this->logger->debug(__FUNCTION__, 'isJson Data: ', $data);
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
                if ($this->bearerToken) {
                    $curl->setHeader("Authorization", 'Bearer ' . $this->bearerToken);
                }
                if ($this->referrer) {
                    $curl->setReferer($this->referrer);
                }
                $curl->setOpt(CURLOPT_RETURNTRANSFER, self::RETURN_TRANSFER);
                $curl->setOpt(CURLOPT_SSL_VERIFYPEER, $this->isSSL);
                $curl->setOpt(CURLOPT_SSL_VERIFYHOST, $this->isSSL);
                $curl->setOpt(CURLOPT_SSLVERSION, 6);
                $curl->setOpt(CURLOPT_ENCODING, self::ENCODING);
                $curl->setOpt(CURLOPT_MAXREDIRS, self::MAX_REDIRECT);
                $curl->setOpt(CURLOPT_TIMEOUT, $this->timeout);
                $curl->setOpt(CURLOPT_CONNECTTIMEOUT, $this->timeout);
                $curl->setOpt(CURLOPT_FOLLOWLOCATION, self::FOLLOW_LOCATION);
                // Request
                if (self::POST == $method) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::POST . ' request to ' . $url . ' with Data: ', $data);
                    $curl->post($url, $data);
                } elseif (self::PUT == $method) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::PUT . ' request to ' . $url . ' with Data: ', $data);
                    $curl->put($url, $data);
                } elseif (self::PATCH == $method) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::PATCH . ' request to ' . $url . ' with Data: ', $data);
                    $curl->patch($url, $data);
                } elseif (self::DELETE == $method) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::DELETE . ' request to ' . $url . ' with Data: ', $data);
                    $curl->delete($url, $data);
                } elseif (self::OPTIONS == $method) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::OPTIONS . ' request to ' . $url . ' with Data: ', $data);
                    $curl->options($url, $data);
                } elseif (self::HEAD == $method) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::HEAD . ' request to ' . $url . ' with Data: ', $data);
                    $curl->head($url, $data);
                } elseif (self::GET == $method) {
                    $this->logger->debug(__FUNCTION__, 'Make ' . self::GET . ' request to ' . $url . ' with Data: ', $data);
                    $curl->get($url, $data);
                } else {
                    $this->logger->debug(__FUNCTION__, 'Make DEFAULT request to ' . $url . ' with Data: ', $data);
                    $curl->get($url, $data);
                }
                $error_code = $this->curlRequestErrorParse($curl);
                // Set Vars
                $this->error_code      = $error_code;
                $this->http_code       = $error_code['http_error']['http_status_code'];
                $this->http_message    = $error_code['http_error']['http_error_message'];
                $this->requests_header = $error_code['headers']['request_headers'];
                $this->response_header = $error_code['headers']['response_headers'];
                // Response
                if ($curl->error) {
                    // Debug
                    $this->logger->debug(__FUNCTION__, 'Full Data Curl Message and Http Message: ', $error_code);
                    if ($this->errorResponseIsData === true) {
                        $this->logger->debug(__FUNCTION__, 'Return Error Response is Array Data');
                        $response = $error_code;
                    } elseif ($this->errorResponseIsNull === true) {
                        $this->logger->debug(__FUNCTION__, 'Return Error Response is Null');
                        $response = null;
                    } else {
                        $errMsg   = $error_code['error_message'];
                        $response = "cURL Error: " . $errMsg;
                        $this->logger->debug(__FUNCTION__, 'Return Error Response is Message: ' . $response);
                    }
                } else {
                    if ($curl->rawResponse) {
                        $response = $curl->rawResponse;
                    } elseif (isset($curl->response)) {
                        $response = $curl->response;
                    } else {
                        $response = null;
                    }
                    $this->logger->debug(__FUNCTION__, 'Response from Request, no Error: ' . $response);
                }
                // Close Request
                $curl->close();
                // Log Response
                if (isset($response)) {
                    $this->logger->debug(__FUNCTION__, 'Final Result from Request: ', $response);
                }
            } catch (Exception $e) {
                $response = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
                $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
                $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());
            }
        }

        return $response;
    }

    /**
     * Function curlRequestErrorParse
     *
     * @param object $curl
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/24/2021 17:53
     */
    protected function curlRequestErrorParse($curl)
    {
        if ($curl->errorCode) {
            $resErrorCode = $curl->errorCode;
        } elseif (isset($curl->error_code)) {
            $resErrorCode = $curl->error_code;
        } else {
            $resErrorCode = null;
        }
        if ($curl->errorMessage) {
            $resErrorMessage = $curl->errorMessage;
        } elseif (isset($curl->error_message)) {
            $resErrorMessage = $curl->error_message;
        } else {
            $resErrorMessage = null;
        }
        if ($curl->curlError) {
            $resErrorCurl = $curl->curlError;
        } elseif (isset($curl->curl_error)) {
            $resErrorCurl = $curl->curl_error;
        } else {
            $resErrorCurl = null;
        }
        if ($curl->curlErrorCode) {
            $resErrorCurlCode = $curl->curlErrorCode;
        } elseif (isset($curl->curl_error_code)) {
            $resErrorCurlCode = $curl->curl_error_code;
        } else {
            $resErrorCurlCode = null;
        }
        if ($curl->curlErrorMessage) {
            $resErrorCurlMessage = $curl->curlErrorMessage;
        } elseif (isset($curl->curl_error_message)) {
            $resErrorCurlMessage = $curl->curl_error_message;
        } else {
            $resErrorCurlMessage = null;
        }
        if ($curl->httpError) {
            $resErrorHttp = $curl->httpError;
        } elseif (isset($curl->http_error)) {
            $resErrorHttp = $curl->http_error;
        } else {
            $resErrorHttp = null;
        }
        if ($curl->httpStatusCode) {
            $resErrorHttpStatusCode = $curl->httpStatusCode;
        } elseif (isset($curl->curl_status_code)) {
            $resErrorHttpStatusCode = $curl->curl_status_code;
        } else {
            $resErrorHttpStatusCode = null;
        }
        if ($curl->httpErrorMessage) {
            $resErrorHttpMessage = $curl->httpErrorMessage;
        } elseif (isset($curl->curl_error_message)) {
            $resErrorHttpMessage = $curl->curl_error_message;
        } else {
            $resErrorHttpMessage = null;
        }
        if ($curl->requestHeaders) {
            $resRequestHeaders = $curl->requestHeaders;
        } elseif (isset($curl->request_headers)) {
            $resRequestHeaders = $curl->request_headers;
        } else {
            $resRequestHeaders = null;
        }
        if ($curl->responseHeaders) {
            $resResponseHeaders = $curl->responseHeaders;
        } elseif (isset($curl->response_headers)) {
            $resResponseHeaders = $curl->response_headers;
        } else {
            $resResponseHeaders = null;
        }

        return array(
            'status'        => $resErrorCode,
            'error'         => $curl->error,
            'error_code'    => $resErrorCode,
            'error_message' => $resErrorMessage,
            'curl_error'    => array(
                'curl_error'         => $resErrorCurl,
                'curl_error_code'    => $resErrorCurlCode,
                'curl_error_message' => $resErrorCurlMessage
            ),
            'http_error'    => array(
                'http_error'         => $resErrorHttp,
                'http_status_code'   => $resErrorHttpStatusCode,
                'http_error_message' => $resErrorHttpMessage
            ),
            'headers'       => array(
                'request_headers'  => $resRequestHeaders,
                'response_headers' => $resResponseHeaders
            )
        );
    }

    /**
     * Function sendRequest
     * Handle send Request use Multi Method
     *
     * @param string $url    URL Endpoint to be Request
     * @param array  $data   Data Content to be Request
     * @param string $method Set Method to be Request
     *
     * @return array|mixed|object|\Psr\Http\Message\ResponseInterface|\Psr\Http\Message\StreamInterface|string|null Response content from server
     *                                              null of Exception Message if Error
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 07:07
     */
    public function sendRequest($url = '', $data = array(), $method = 'GET')
    {
        $this->logger->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $inputParams = array('url' => $url, 'data' => $data, 'method' => $method);
        $this->logger->debug(__FUNCTION__, 'input Params: ', $inputParams);
        $method   = strtoupper($method);
        $endpoint = trim($url);
        $this->logger->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        if (!extension_loaded('curl')) {
            $this->logger->critical(__FUNCTION__, 'Server is not Support cURL, Please cURL. Library fallback user File Get Contents');
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
            $this->logger->debug(__FUNCTION__, 'Get Content Result: ' . $getContent);
            $this->logger->debug(__FUNCTION__, 'Get Error Result: ' . $getError);
        } else {
            try {
                $useGuzzlePhp = [self::HEAD, self::TRACE, self::OPTIONS];
                $this->logger->debug(__FUNCTION__, 'Make ' . $method . ' request to ' . $url . ' with Data: ', $data);
                if (in_array($method, $useGuzzlePhp)) {
                    $result = $this->guzzlePhpRequest($url, $data, $method);
                } else {
                    $result = $this->curlRequest($url, $data, $method);
                }
            } catch (Exception $e) {
                $result = "Error File: " . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
                $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
                $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());
            }
        }
        $this->logger->debug(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }

    /**
     * Function xmlRequest
     * Send XML Request to Server
     *
     * @param string $url     URL Endpoint to be Request
     * @param string $data    Data Content to be Request
     * @param int    $timeout Timeout Request
     *
     * @return array|null|string Response from Server
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:11
     *
     */
    public function xmlRequest($url = '', $data = '', $timeout = 60)
    {
        $this->logger->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $endpoint = trim($url);
        $this->logger->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        $inputParams = array('url' => $url, 'data' => $data, 'timeout' => $timeout);
        $this->logger->debug(__FUNCTION__, 'input Params: ', $inputParams);
        if (!extension_loaded('curl')) {
            $this->logger->critical(__FUNCTION__, 'Server is not Support cURL, Please cURL. Library fallback user File Get Contents');

            // Create Request use File Get Content
            $content                  = new GetContents();
            $content->debugStatus     = $this->debugStatus;
            $content->debugLoggerPath = $this->debugLoggerPath;
            $content->__construct();
            $content->setURL($url);
            $content->setMethod('POST');
            $content->setXML(true);
            $content->setData($data);
            $content->sendRequest();

            // Create Request
            $result     = $content->response();
            $getContent = $content->getContent();
            $getError   = $content->getError();
            $this->logger->debug(__FUNCTION__, 'Get Content Result: ' . $getContent);
            $this->logger->debug(__FUNCTION__, 'Get Error Result: ' . $getError);
        } else {
            $this->setRequestIsXml(true);
            $this->setTimeout($timeout);
            $result = $this->curlRequest($url, $data, 'POST');
        }
        $this->logger->debug(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }

    /**
     * Function jsonRequest
     * Send JSON Request to Server
     *
     * @param string $url     URL Endpoint to be Request
     * @param array  $data    Data Content to be Request
     * @param int    $timeout Timeout Request
     *
     * @return array|null|string Response from Server
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:13
     *
     */
    public function jsonRequest($url = '', $data = array(), $timeout = 60)
    {
        $this->logger->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        $endpoint = trim($url);
        $this->logger->debug(__FUNCTION__, 'cURL Endpoint: ', $endpoint);
        $inputParams = array('url' => $url, 'data' => $data, 'timeout' => $timeout);
        $this->logger->debug(__FUNCTION__, 'input Params: ', $inputParams);
        if (!extension_loaded('curl')) {
            $this->logger->critical(__FUNCTION__, 'Server is not Support cURL, Please cURL. Library fallback user File Get Contents');

            // Create Request use File Get Content
            $content                  = new GetContents();
            $content->debugStatus     = $this->debugStatus;
            $content->debugLoggerPath = $this->debugLoggerPath;
            $content->__construct();
            $content->setURL($url);
            $content->setMethod('POST');
            $content->setJson(true);
            $content->setData($data);
            $content->sendRequest();

            // Create Request
            $result     = $content->response();
            $getContent = $content->getContent();
            $getError   = $content->getError();
            $this->logger->debug(__FUNCTION__, 'Get Content Result: ' . $getContent);
            $this->logger->debug(__FUNCTION__, 'Get Error Result: ' . $getError);
        } else {
            $this->setRequestIsJson(true);
            $this->setTimeout($timeout);
            $result = $this->curlRequest($url, $data, 'POST');
        }
        $this->logger->debug(__FUNCTION__, 'Final Result from Request: ', $result);

        return $result;
    }

    /**
     * Function xmlGetValue
     *
     * @param string $xml      XML String
     * @param string $openTag  OpenTag to find
     * @param string $closeTag CloseTag to find
     *
     * @return bool|string  Result from Tag, Empty string if not
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 06:57
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
     * @param string $resultXml XML String to Parse
     *
     * @return false|string
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 06:57
     */
    public function parseXmlDataRequest($resultXml = '')
    {
        $array = array(
            'ec'  => $this->xmlGetValue($resultXml, "<ec>", "</ec>"),
            'msg' => $this->xmlGetValue($resultXml, "<msg>", "</msg>")
        );

        return json_encode($array);
    }
}
