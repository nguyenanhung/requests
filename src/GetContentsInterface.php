<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 01:45
 */

namespace nguyenanhung\MyRequests;

/**
 * Interface GetContentsInterface
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface GetContentsInterface
{
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
    public function getContent();

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
    public function getError();

    /**
     * Function get Response of Request
     *
     * @return array|mixed|object|null Array if Exists, Null if Not Response
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:50
     */
    public function response();

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
    public function sendRequest();

    /**
     * Function useFileGetContents. Use file_get_contents to perform the request
     *
     * @return array The server response array
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:19
     */
    public function useFileGetContents();

    /**
     * Generate the complete header array. Merges the supplied (if any) headers with those needed by the request.
     *
     * @return array An array of headers
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:19
     */
    public function getHeaderArray();

    /**
     * Get the post body - either JSON encoded or ready to be sent as a form post
     *
     * @return array|false|string Data to be sent Request
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:19
     */
    public function getPostBody();

    /**
     * Get the query string by merging any supplied string with that of the generated components.
     *
     * @return string The query string
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:19
     */
    public function getQueryString();

    /**
     * Set the target URL - Must include http:// or https://
     *
     * @param string $url
     *
     * @return string
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:10
     */
    public function setURL($url = '');

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
    public function setMethod($method = '');

    /**
     * Set Data contents. Must be supplied as an array
     *
     * @param array $data The contents to be sent to the target URL
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:18
     */
    public function setData($data = array());

    /**
     * Set query string data. Must be supplied as an array
     *
     * @param array $query_string The query string to be sent to the target URL
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 01:36
     */
    public function setQueryString($query_string = array());

    /**
     * Set any headers to be sent to the target URL. Must be supplied as an array
     *
     * @param array $headers Header to Set
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:18
     */
    public function setHeaders($headers = array());

    /**
     * Set any cookies to be included in the headers. Must be supplied as an array
     *
     * @param array $cookies The array of cookies to be sent
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:18
     */
    public function setCookies($cookies = array());

    /**
     * Should cookies be tracked?
     *
     * @param boolean $value true to track cookies
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:18
     */
    public function setTrackCookies($value = FALSE);

    /**
     * Function setXML - Is this transaction sending / expecting XML
     *
     * @param bool $value true if XML is being used and is expected
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 01:38
     */
    public function setXML($value = FALSE);

    /**
     * Is this transaction sending / expecting JSON
     *
     * @param boolean $value true if JSON is being used and is expected
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:17
     */
    public function setJson($value = FALSE);

    /**
     * Should JSON being sent be encoded in an easily readable format? Only useful for debugging
     *
     * @param boolean $value true for JSON_PRETTY_PRINT
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:17
     */
    public function setJsonPretty($value = FALSE);

    /**
     * Should SSL peers be verified?
     *
     * @param bool $value
     *
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/7/18 02:17
     */
    public function setVerifyPeer($value = FALSE);

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
    public function setTimeout($timeout = 20);

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
    public function parseReturnHeaders($headers);
}
