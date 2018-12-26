<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 01:14
 */

namespace nguyenanhung\MyRequests;

use \Exception;
use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\MyRequests\Interfaces\ProjectInterface;

/**
 * Class GetContents
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class GetContents implements ProjectInterface, GetContentsInterface
{
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
     * Response from Request
     *
     * @var array
     */
    private $response;

    /**
     * The base URL to be the target of the Request
     *
     * @var string
     */
    private $url = '';

    /**
     * The method to use - GET, POST, PUT, DELETE
     *
     * @var string
     */
    private $method = 'GET';

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
     * An array of data to be added to the request.
     * Where the method is POST these are sent as a form body,
     * otherwise - they are added as a query string
     *
     * @var array
     */
    private $data = [];

    /**
     * An array of items to be sent as a query string
     *
     * @var array
     */
    private $query_string = [];

    /**
     * Should we track cookies?
     * This does not stop the processing of cookies, it just allows for any
     * received cookies to be sent in subsequent requests. Great for scraping.
     *
     * @var [type]
     */
    private $trackCookies = TRUE;

    /**
     * Is the request sent in XML and received in XML
     *
     * @var boolean
     */
    private $isXML = FALSE;

    /**
     * Is the request sent in JSON and received in JSON
     *
     * @var boolean
     */
    private $isJson = FALSE;
    /**
     * Is the response decode Json to Object
     *
     * @var boolean
     */
    private $isDecodeJson = FALSE;

    /**
     * Should JSON be sent in JSON_PRETTY_PRINT?
     * Only really useful for debugging.
     *
     * @var boolean
     */
    private $isJsonPretty = FALSE;

    /**
     * Should SSL peers be verified.
     * You should have a good reason for turning this off.
     *
     * @var [type]
     */
    private $verifyPeer = TRUE;

    /**
     * How long to wait for a server to respond to a  request.
     *
     * @var integer
     */
    private $timeout = 60;

    /**
     * Internal flag to track if the request is in SSL or not.
     *
     * @var boolean
     */
    private $isSSL = FALSE;

    /**
     * GetContents constructor.
     *
     * @param string $url     Url Endpoint
     * @param string $method  The method to use - GET, POST, PUT, DELETE
     * @param array  $data    An array of data to be added to the request.'
     *                        Where the method is POST these are sent as a form body,
     *                        otherwise - they are added as a query string
     * @param array  $headers An array of headers to be added to the request
     */
    public function __construct($url = '', $method = 'GET', $data = [], $headers = [])
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark = new Benchmark();
            $this->benchmark->mark('code_start');
        }
        /**
         * Call to class Debug
         */
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
        $this->debug->debug(__FUNCTION__, '/-------------------------> Begin Logger - File Get Contents Requests - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
        if ($url) {
            /**
             * If $url is not Empty, call method setURL
             */
            $this->setURL($url);
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
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark->mark('code_end');
            $this->debug->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->debug->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
        $this->debug->debug(__FUNCTION__, '/-------------------------> End Logger - File Get Contents Requests - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
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
     * Function getContent - Get Body Content from Request
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:08
     *
     * @return array|mixed|string Return Response content if exists
     *                            Full Response content if $this->response['content'] not exists
     *                            Exception Error Message if Exception Error
     *                            Null if Not
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
        }
        catch (Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return $message;
        }

        return NULL;
    }

    /**
     * Function getError - Get Error Code and Message
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 09:33
     *
     * @return array|mixed|string Return Response error if exists
     *                            Full Response if $this->response['error'] not exists
     *                            Exception Error Message if Exception Error
     *                            Null if Not
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
        }
        catch (Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return $message;
        }

        return NULL;
    }

    /**
     * Function get Response of Request
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:50
     *
     * @return array|null Array if Exists, Null if Not Response
     */
    public function response()
    {
        if ($this->response) {
            return $this->response;
        }

        return NULL;
    }

    /**
     * Let's go to Request
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:12
     *
     * @return array|null|string Response from Request if Exists
     *                           Exception Error Message if Exception Error
     *                           Null if Not
     */
    public function sendRequest()
    {
        try {
            if (mb_strlen($this->url) >= 9) {
                $response       = $this->useFileGetContents();
                $this->response = $response;

                return $response;
            }
        }
        catch (Exception $e) {
            $message = "Error: " . __CLASS__ . ": Please make sure to set a URL to fetch - Line: " . $e->getLine() . ' - Msg: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return $message;
        }

        return NULL;
    }

    /**
     * Function useFileGetContents
     * Use file_get_contents to perform the request
     *
     * @return array The server response array
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:19
     */
    public function useFileGetContents()
    {
        $return  = [];
        $options = [
            'http' => [
                'method'  => $this->method,
                'timeout' => $this->timeout
            ]
        ];

        if ($this->isSSL) {
            // use SSL
            $options['ssl'] = [
                'verify_peer'      => $this->verifyPeer,
                'verify_peer_name' => $this->verifyPeer
            ];
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
        $this->debug->debug(__FUNCTION__, 'Options into Request: ', $options);
        $this->debug->debug(__FUNCTION__, 'Data Query String into Request: ', $query_string);
        $this->debug->debug(__FUNCTION__, 'Endpoint URL into Request: ', $this->url);
        try {
            $response          = file_get_contents($this->url . $query_string, FALSE, $context);
            $responseHeaders   = $http_response_header;
            $return['headers'] = $this->parseReturnHeaders($responseHeaders);
            $return['url']     = $this->url . $query_string;
            if ($response) {
                $return['content'] = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($response));
                if ($this->isJson === TRUE && $this->isDecodeJson === TRUE) {
                    $responseJson = json_decode(trim($return['content']));
                    if (json_last_error() == JSON_ERROR_NONE) {
                        $return['content'] = $responseJson;
                        $this->debug->debug(__FUNCTION__, 'Set Response is Json: ', $return['content']);
                    }
                }
            }
        }

        catch (Exception $e) {
            $return['error'] = [
                'code'     => 500,
                'message'  => 'Could not file_get_contents.',
                'extended' => $e
            ];
            $this->debug->error(__FUNCTION__, 'Could not file_get_contents: ', $return['error']);
        }

        if (isset($return['headers']['reponse_code'])) {
            $responseType = substr($return['headers']['reponse_code'], 0, 1);
            if ($responseType != '2') {
                $return['error'] = [
                    'code'    => $return['headers']['reponse_code'],
                    'message' => 'Server returned an error.'
                ];
                $this->debug->error(__FUNCTION__, 'Could not file_get_contents: ', $return['error']);
            }
        }

        $cookies = [];
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
        $this->debug->info(__FUNCTION__, 'Final Result from Server: ', $return);

        return $return;
    }

    /**
     * Generate the complete header array
     * Merges the supplied (if any) headers with those needed by the
     * request.
     *
     * @return array An array of headers
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:19
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
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:19
     *
     * @return array|false|string Data to be sent Request
     */
    public function getPostBody()
    {
        $output = '';
        if ($this->isJson) {
            $jsonPretty = ($this->isJsonPretty ? JSON_PRETTY_PRINT : NULL);
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
     * Get the query string by merging any supplied string
     * with that of the generated components.
     *
     * @return string The query string
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:19
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
     * Set the target URL
     * Must include http:// or https://
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:10
     *
     * @param string $url
     *
     * @return string
     */
    public function setURL($url = '')
    {
        try {
            if (mb_strlen($url) > 0) {
                if (substr($url, 0, 8) == 'https://') {
                    $this->isSSL = TRUE;
                    $this->debug->debug(__FUNCTION__, 'Set SSL: ' . $this->isSSL);
                } elseif (substr($url, 0, 7) == 'http://') {
                    $this->isSSL = TRUE;
                    $this->debug->debug(__FUNCTION__, 'Set SSL: ' . $this->isSSL);
                }
            }
            $this->url = $url;
        }
        catch (Exception $e) {
            $this->url = NULL;
            $message   = "Error: " . __CLASS__ . ": Invalid protocol specified. URL must start with http:// or https:// - " . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return $message;
        }
        $this->debug->debug(__FUNCTION__, 'Endpoint URL to Request: ', $this->url);

        return $this;
    }

    /**
     * Set the HTTP method
     * GET, HEAD, PUT, POST are valid
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:15
     *
     * @param string $method Method to Request GET, HEAD, PUT, POST are valid
     *
     * @return $this|string Method
     */
    public function setMethod($method = '')
    {
        if (mb_strlen($method) == 0) {
            $this->debug->debug(__FUNCTION__, 'Set Default Method = GET if $method is does not exist');
            $method = 'GET';
        } else {
            $method       = strtoupper($method);
            $validMethods = [
                'GET',
                'HEAD',
                'PUT',
                'POST',
                'DELETE'
            ];
            if (!in_array($method, $validMethods)) {
                $message = "Error: " . __CLASS__ . ": The requested method (${method}) is not valid here";
                $this->debug->error(__FUNCTION__, $message);

                return $message;
            }
        }
        $this->method = $method;

        return $this;
    }

    /**
     * Set Data contents
     * Must be supplied as an array
     *
     * @param array $data The contents to be sent to the target URL
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:18
     */
    public function setData($data = [])
    {
        if (!is_array($data) && is_string($data)) {
            $data = parse_str($data);
        }
        if (count($data) == 0) {
            $this->data = [];
        } else {
            $this->data = $data;
        }
        $this->debug->debug(__FUNCTION__, 'Data into Request: ', $this->data);
    }

    /**
     * Set query string data
     * Must be supplied as an array
     *
     * @param array $query_string The query string to be sent to the target URL
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:36
     */
    public function setQueryString($query_string = [])
    {
        if (!is_array($query_string) && is_string($query_string)) {
            $query_string = parse_str($query_string);
        }
        if (count($query_string) == 0) {
            $this->query_string = [];
        } else {
            $this->query_string = $query_string;
        }
    }

    /**
     * Set any headers to be sent to the target URL
     * Must be supplied as an array
     *
     * @param array $headers Header to Set
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:18
     */
    public function setHeaders($headers = [])
    {
        if (!is_array($headers)) {
            $this->headers = [];
        } else {
            $this->headers = $headers;
        }
    }

    /**
     * Set any cookies to be included in the headers
     * Must be supplied as an array
     *
     * @param array $cookies The array of cookies to be sent
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:18
     */
    public function setCookies($cookies = [])
    {
        if (!is_array($cookies)) {
            $this->cookies = [];
        } else {
            $this->cookies      = $cookies;
            $this->trackCookies = TRUE;
        }
    }

    /**
     * Should cookies be tracked?
     *
     * @param boolean $value true to track cookies
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:18
     */
    public function setTrackCookies($value = FALSE)
    {
        if (!$value) {
            $this->trackCookies = FALSE;
        } else {
            $this->trackCookies = TRUE;
        }
    }

    /**
     * Function setXML - Is this transaction sending / expecting XML
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:38
     *
     * @param bool $value true if XML is being used and is expected
     */
    public function setXML($value = FALSE)
    {
        if (!$value) {
            $this->isXML = FALSE;
        } else {
            $this->isXML = TRUE;
        }
    }

    /**
     * Is this transaction sending / expecting JSON
     *
     * @param boolean $value true if JSON is being used and is expected
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:17
     */
    public function setJson($value = FALSE)
    {
        if (!$value) {
            $this->isJson = FALSE;
        } else {
            $this->isJson = TRUE;
        }
    }

    /**
     * Should JSON being sent be encoded in an easily readable format?
     * Only useful for debugging
     *
     * @param boolean $value true for JSON_PRETTY_PRINT
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:17
     */
    public function setJsonPretty($value = FALSE)
    {
        if (!$value) {
            $this->isJsonPretty = FALSE;
        } else {
            $this->isJsonPretty = TRUE;
        }
    }

    /**
     * Should SSL peers be verified?
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:17
     *
     * @param bool $value
     */
    public function setVerifyPeer($value = FALSE)
    {
        if (!$value) {
            $this->verifyPeer = FALSE;
        } else {
            $this->verifyPeer = TRUE;
        }
    }

    /**
     * Function setTimeout
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/7/18 02:17
     *
     * @param int $timeout
     *
     * @example 60
     */
    public function setTimeout($timeout = 20)
    {
        $this->timeout = $timeout;
    }

    /**
     * Parse HTTP response headers
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:17
     *
     * @param array $headers
     *
     * @return array Header Response
     */
    public function parseReturnHeaders($headers)
    {
        $head = [];
        foreach ($headers as $k => $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1])) {
                $head[trim($t[0])] = trim($t[1]);
            } else {
                $head[] = $v;
                if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out)) {
                    $head['reponse_code'] = intval($out[1]);
                }
            }
        }
        $this->debug->debug(__FUNCTION__, 'Response Header: ', $head);

        return $head;
    }
}
