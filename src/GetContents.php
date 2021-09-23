<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 01:14
 */

namespace nguyenanhung\MyRequests;

use Exception;
use nguyenanhung\MyDebug\Logger;
use nguyenanhung\MyDebug\Benchmark;

/**
 * Class GetContents
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class GetContents implements ProjectInterface
{
    use Version;

    /** @var object \nguyenanhung\MyDebug\Benchmark */
    private $benchmark;

    /** @var object \nguyenanhung\MyDebug\Debug */
    private $logger;

    /** @var bool Set Debug Status */
    public $debugStatus = false;

    /** @var null|string Set level Debug: DEBUG, INFO, ERROR .... */
    public $debugLevel = 'error';

    /** @var string Set Logger Path to Save */
    public $debugLoggerPath = '';

    /** @var string|null Set Logger Filename to Save */
    public $debugLoggerFilename = '';

    /** @var null|array|object|mixed Response from Request */
    private $response;

    /** @var string The base URL to be the target of the Request */
    private $url = '';

    /** @var string The method to use - GET, POST, PUT, DELETE */
    private $method = 'GET';

    /** @var array An array of headers to be added to the request */
    private $headers = array();

    /** @var array An array of cookies (which are added to the headers) */
    private $cookies = array();

    /** @var array An array of data to be added to the request. Where the method is POST these are sent as a form body, otherwise - they are added as a query string */
    private $data = array();

    /** @var array An array of items to be sent as a query string */
    private $query_string = array();

    /** @var bool|mixed Should we track cookies? This does not stop the processing of cookies, it just allows for any received cookies to be sent in subsequent requests. Great for scraping. */
    private $trackCookies = true;

    /** @var bool Is the request sent in XML and received in XML */
    private $isXML = false;

    /** @var bool Is the request sent in JSON and received in JSON */
    private $isJson = false;

    /** @var bool Is the response decode Json to Object */
    private $isDecodeJson = false;

    /** @var bool Should JSON be sent in JSON_PRETTY_PRINT? Only really useful for debugging. */
    private $isJsonPretty = false;

    /** @var bool|mixed Should SSL peers be verified. You should have a good reason for turning this off. */
    private $verifyPeer = true;

    /** @var int How long to wait for a server to respond to a  request. */
    private $timeout = 60;

    /** @var bool Internal flag to track if the request is in SSL or not. */
    private $isSSL = false;

    /**
     * GetContents constructor.
     *
     * @param string $url     Url Endpoint
     * @param string $method  The method to use - GET, POST, PUT, DELETE
     * @param array  $data    An array of data to be added to the request.'
     *                        Where the method is POST these are sent as a form body,
     *                        otherwise - they are added as a query string
     * @param array  $headers An array of headers to be added to the request
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct(string $url = '', string $method = 'GET', array $data = array(), array $headers = array())
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
        if ($url) {
            $this->setURL($url); // If $url is not Empty, call method setURL
        }
        $this->setMethod($method);
        $this->setData($data);
        $this->setHeaders($headers);
    }

    /**
     * GetContents destructor.
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
     * Function getContent - Get Body Content from Request
     *
     * @return array|mixed|object|string|null Return Response content if exists
     *                            Full Response content if $this->response['content'] not exists
     *                            Exception Error Message if Exception Error
     *                            Null if Not
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/7/18 02:08
     */
    public function getContent()
    {
        try {
            if ($this->response) {
                if (isset($this->response['content'])) {
                    return $this->response['content'];
                } else {
                    return $this->response;
                }
            }
        } catch (Exception $e) {
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
            $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());

            return $e->getMessage();
        }

        return null;
    }

    /**
     * Function getError - Get Error Code and Message
     *
     * @return array|mixed|object|string|null Return Response error if exists
     *                            Full Response if $this->response['error'] not exists
     *                            Exception Error Message if Exception Error
     *                            Null if Not
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/9/18 09:33
     */
    public function getError()
    {
        try {
            if ($this->response) {
                if (isset($this->response['error'])) {
                    return $this->response['error'];
                } else {
                    return $this->response;
                }
            }
        } catch (Exception $e) {
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
            $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());

            return $e->getMessage();
        }

        return null;
    }

    /**
     * Function get Response of Request
     *
     * @return array|mixed|object|null Array if Exists, Null if Not Response
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:50
     */
    public function response()
    {
        if ($this->response) {
            return $this->response;
        }

        return null;
    }

    /**
     * Let's go to Request
     *
     * @return array|null|string Response from Request if Exists
     *                           Exception Error Message if Exception Error
     *                           Null if Not
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:12
     */
    public function sendRequest()
    {
        try {
            if (mb_strlen($this->url) >= 9) {
                $response       = $this->useFileGetContents();
                $this->response = $response;

                return $response;
            }
        } catch (Exception $e) {
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
            $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());

            return $e->getMessage();
        }

        return null;
    }

    /**
     * Function useFileGetContents. Use file_get_contents to perform the request
     *
     * @return array The server response array
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:19
     */
    public function useFileGetContents()
    {
        $return = array();

        // Options Setup
        $options = array(
            'http' => array(
                'method'  => $this->method,
                'timeout' => $this->timeout
            )
        );

        // Use SSL
        if ($this->isSSL) {
            $options['ssl'] = array(
                'verify_peer'      => $this->verifyPeer,
                'verify_peer_name' => $this->verifyPeer
            );
        }

        $headers = $this->getHeaderArray();

        if (count($headers) > 0) {
            $options['http']['header'] = implode("\r\n", $headers);
        }

        if ($this->method == 'POST') {
            $post = $this->getPostBody();
            if (mb_strlen($post) > 0) {
                $options['http']['content'] = $post;
            }
            $return['post'] = $post;
        }

        $context      = stream_context_create($options);
        $query_string = $this->getQueryString();
        $this->logger->debug(__FUNCTION__, 'Options into Request: ', $options);
        $this->logger->debug(__FUNCTION__, 'Data Query String into Request: ', $query_string);
        $this->logger->debug(__FUNCTION__, 'Endpoint URL into Request: ', $this->url);
        try {
            $response          = file_get_contents($this->url . $query_string, false, $context);
            $responseHeaders   = $http_response_header;
            $return['headers'] = $this->parseReturnHeaders($responseHeaders);
            $return['url']     = $this->url . $query_string;
            if ($response) {
                $return['content'] = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($response));
                if ($this->isJson === true && $this->isDecodeJson === true) {
                    $responseJson = json_decode(trim($return['content']));
                    if (json_last_error() == JSON_ERROR_NONE) {
                        $return['content'] = $responseJson;
                        $this->logger->debug(__FUNCTION__, 'Set Response is Json: ', $return['content']);
                    }
                }
            }
        } catch (Exception $e) {
            $return['error'] = array(
                'code'     => 500,
                'message'  => 'Could not file_get_contents.',
                'extended' => $e
            );
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
            $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());
        }

        if (isset($return['headers']['response_code'])) {
            $responseType = substr($return['headers']['response_code'], 0, 1);
            if ($responseType != '2') {
                $return['error'] = array(
                    'code'    => $return['headers']['response_code'],
                    'message' => 'Server returned an error.'
                );
                $this->logger->error(__FUNCTION__, 'Could not file_get_contents: ', $return['error']);
            }
        }

        $cookies = array();
        foreach ($http_response_header as $hdr) {
            if (preg_match('/^Set-Cookie:\s*([^;]+)/i', $hdr, $matches)) {
                parse_str($matches[1], $tmp);
                $cookies += $tmp;
            }
        }

        if ($this->trackCookies) {
            $cookies       = array_merge($this->cookies, $cookies);
            $this->cookies = $cookies;
        }
        $return['cookies'] = $cookies;
        $this->logger->info(__FUNCTION__, 'Final Result from Server: ', $return);

        return $return;
    }

    /**
     * Generate the complete header array. Merges the supplied (if any) headers with those needed by the request.
     *
     * @return array An array of headers
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:19
     */
    public function getHeaderArray()
    {
        $headerArray = (count($this->headers) > 0 ? $this->headers : []);
        if ($this->isJson) {
            $headerArray[] = 'Accept: application/json';
        }
        if ($this->isXML) {
            $headerArray[] = 'Accept: text/xml';
        }
        if ($this->method == 'POST' && count($this->data) > 0 && $this->isJson) {
            $headerArray[] = 'Content-type: application/json';
        } elseif ($this->method == 'POST' && count($this->data) > 0 && $this->isXML) {
            $headerArray[] = 'Content-type: text/xml';
        } elseif ($this->method == 'POST' && count($this->data) > 0) {
            $headerArray[] = 'Content-type: application/x-www-form-urlencoded';
        }
        if (count($this->cookies) > 0) {
            $cookies = '';
            foreach ($this->cookies as $key => $value) {
                if (mb_strlen($cookies) > 0) {
                    $cookies .= '; ';
                }
                $cookies .= urlencode($key) . '=' . urlencode($value);
            }
            $headerArray[] = 'Cookie: ' . $cookies;
        }

        return $headerArray;
    }

    /**
     * Get the post body - either JSON encoded or ready to be sent as a form post
     *
     * @return array|false|string Data to be sent Request
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:19
     */
    public function getPostBody()
    {
        $output = '';
        if ($this->isJson) {
            $jsonPretty = ($this->isJsonPretty ? JSON_PRETTY_PRINT : null);
            if (count($this->data) > 0) {
                $output = json_encode($this->data, $jsonPretty);
            }
        } elseif ($this->isXML) {
            $output = $this->data;
        } elseif (count($this->data) > 0) {
            $output = http_build_query($this->data);
        }

        return $output;
    }

    /**
     * Get the query string by merging any supplied string with that of the generated components.
     *
     * @return string The query string
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:19
     */
    public function getQueryString()
    {
        $query_string = '';
        if (count($this->query_string) > 0) {
            $query_string .= http_build_query($this->query_string);
        }
        if ($this->method != 'POST') {
            if (count($this->data) > 0) {
                $query_string .= http_build_query($this->data);
            }
        }
        if (mb_strlen($query_string) > 0) {
            $query_string = (mb_strpos($this->url, '?') ? '&' : '?') . $query_string;
        }

        return $query_string;
    }

    /**
     * Set the target URL - Must include http:// or https://
     *
     * @param string $url
     *
     * @return $this
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:10
     */
    public function setURL($url = '')
    {
        try {
            if (mb_strlen($url) > 0) {
                if (substr($url, 0, 8) == 'https://') {
                    $this->isSSL = true;
                    $this->logger->debug(__FUNCTION__, 'Set SSL: ' . $this->isSSL);
                } elseif (substr($url, 0, 7) == 'http://') {
                    $this->isSSL = true;
                    $this->logger->debug(__FUNCTION__, 'Set SSL: ' . $this->isSSL);
                }
            }
            $this->url = $url;
        } catch (Exception $e) {
            $this->url = null;
            $message   = "Error: " . __CLASS__ . ": Invalid protocol specified. URL must start with http:// or https:// - " . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $message);
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
            $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());
        }
        $this->logger->debug(__FUNCTION__, 'Endpoint URL to Request: ', $this->url);

        return $this;
    }

    /**
     * Set the HTTP method: GET, HEAD, PUT, POST, DELETE are valid
     *
     * @param string $method Method to Request GET, HEAD, PUT, POST, DELETE are valid
     *
     * @return $this|string Method
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:15
     */
    public function setMethod($method = '')
    {
        if (mb_strlen($method) == 0) {
            $this->logger->debug(__FUNCTION__, 'Set Default Method = GET if $method is does not exist');
            $method = 'GET';
        } else {
            $method       = strtoupper($method);
            $validMethods = array('GET', 'HEAD', 'PUT', 'POST', 'DELETE');
            if (!in_array($method, $validMethods)) {
                $message = "Error: " . __CLASS__ . ": The requested method (${method}) is not valid here";
                $this->logger->error(__FUNCTION__, $message);

                return $message;
            }
        }
        $this->method = $method;

        return $this;
    }

    /**
     * Set Data contents. Must be supplied as an array
     *
     * @param array $data The contents to be sent to the target URL
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:18
     */
    public function setData($data = array())
    {
        if (!is_array($data) && is_string($data)) {
            $data = parse_str($data);
        }
        if (count($data) == 0) {
            $this->data = array();
        } else {
            $this->data = $data;
        }
        $this->logger->debug(__FUNCTION__, 'Data into Request: ', $this->data);
    }

    /**
     * Set query string data. Must be supplied as an array
     *
     * @param array|string $query_string The query string to be sent to the target URL
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 01:36
     */
    public function setQueryString($query_string = array())
    {
        if (!is_array($query_string) && is_string($query_string)) {
            $query_string = parse_str($query_string);
        }
        if (count($query_string) === 0) {
            $this->query_string = array();
        } else {
            $this->query_string = $query_string;
        }
    }

    /**
     * Set any headers to be sent to the target URL. Must be supplied as an array
     *
     * @param array $headers Header to Set
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:18
     */
    public function setHeaders($headers = array())
    {
        if (!is_array($headers)) {
            $this->headers = array();
        } else {
            $this->headers = $headers;
        }
    }

    /**
     * Set any cookies to be included in the headers. Must be supplied as an array
     *
     * @param array $cookies The array of cookies to be sent
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:18
     */
    public function setCookies($cookies = array())
    {
        if (!is_array($cookies)) {
            $this->cookies = array();
        } else {
            $this->cookies      = $cookies;
            $this->trackCookies = true;
        }
    }

    /**
     * Should cookies be tracked?
     *
     * @param boolean $value true to track cookies
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:18
     */
    public function setTrackCookies($value = false)
    {
        if (!$value) {
            $this->trackCookies = false;
        } else {
            $this->trackCookies = true;
        }
    }

    /**
     * Function setXML - Is this transaction sending / expecting XML
     *
     * @param bool $value true if XML is being used and is expected
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 01:38
     */
    public function setXML($value = false)
    {
        if (!$value) {
            $this->isXML = false;
        } else {
            $this->isXML = true;
        }
    }

    /**
     * Is this transaction sending / expecting JSON
     *
     * @param boolean $value true if JSON is being used and is expected
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:17
     */
    public function setJson($value = false)
    {
        if (!$value) {
            $this->isJson = false;
        } else {
            $this->isJson = true;
        }
    }

    /**
     * Should JSON being sent be encoded in an easily readable format? Only useful for debugging
     *
     * @param boolean $value true for JSON_PRETTY_PRINT
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:17
     */
    public function setJsonPretty($value = false)
    {
        if (!$value) {
            $this->isJsonPretty = false;
        } else {
            $this->isJsonPretty = true;
        }
    }

    /**
     * Should SSL peers be verified?
     *
     * @param bool $value
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:17
     */
    public function setVerifyPeer($value = false)
    {
        if (!$value) {
            $this->verifyPeer = false;
        } else {
            $this->verifyPeer = true;
        }
    }

    /**
     * Function setTimeout
     *
     * @param int $timeout
     *
     * @example     60
     *
     * @author      : 713uk13m <dev@nguyenanhung.com>
     * @copyright   : 713uk13m <dev@nguyenanhung.com>
     * @time        : 10/7/18 02:17
     */
    public function setTimeout($timeout = 20)
    {
        $this->timeout = $timeout;
    }

    /**
     * Parse HTTP response headers
     *
     * @param array $headers
     *
     * @return array Header Response
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:17
     */
    public function parseReturnHeaders($headers)
    {
        $head = array();
        foreach ($headers as $value) {
            $t = explode(':', $value, 2);
            if (isset($t[1])) {
                $head[trim($t[0])] = trim($t[1]);
            } else {
                $head[]      = $value;
                $patternHttp = "#HTTP/[0-9\.]+\s+([0-9]+)#";
                if (preg_match($patternHttp, $value, $out)) {
                    $head['response_code'] = intval($out[1]);
                }
            }
        }
        $this->logger->debug(__FUNCTION__, 'Response Header: ', $head);

        return $head;
    }
}
