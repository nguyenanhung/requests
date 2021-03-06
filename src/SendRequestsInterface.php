<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 03:45
 */

namespace nguyenanhung\MyRequests;

/**
 * Interface SendRequestsInterface
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface SendRequestsInterface
{
    /**
     * Function setHeader
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeader($headers = array());

    /**
     * Function setCookie
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param array $cookies
     *
     * @return $this
     */
    public function setCookie($cookies = array());

    /**
     * Function setOptions
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions($options = array());

    /**
     * Function setTimeout
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param int $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout = 60);

    /**
     * Function setUserAgent
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param string $userAgent
     *
     * @return $this
     */
    public function setUserAgent($userAgent = '');

    /**
     * Function setReferrer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param string $referrer
     *
     * @return $this
     */
    public function setReferrer($referrer = '');

    /**
     * Function setUserBody
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param bool $isBody
     *
     * @return $this
     */
    public function setUserBody($isBody = FALSE);

    /**
     * Function setRequestIsXml
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param bool $isXml
     *
     * @return $this
     */
    public function setRequestIsXml($isXml = FALSE);

    /**
     * Function setRequestIsJson
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param bool $isJson
     *
     * @return $this
     */
    public function setRequestIsJson($isJson = FALSE);

    /**
     * Function setRequestIsSSL
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 20:03
     *
     * @param bool $isSSL
     *
     * @return $this
     */
    public function setRequestIsSSL($isSSL = FALSE);

    /**
     * Function setErrorResponseIsData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:04
     *
     * @param bool $errorResponseIsData Array Data if Response is Null if Error
     *
     * @return $this
     */
    public function setErrorResponseIsData($errorResponseIsData = FALSE);

    /**
     * Function setErrorResponseIsNull
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:04
     *
     * @param bool $errorResponseIsNull TRUE if Response is Null if Error
     *
     * @return $this
     */
    public function setErrorResponseIsNull($errorResponseIsNull = FALSE);

    /**
     * Function setBasicAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param string $username Username to be Authentication
     * @param string $password Password to be Authentication
     *
     * @return $this
     */
    public function setBasicAuthentication($username = '', $password = '');

    /**
     * Function setDigestAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param string $username Username to be Authentication
     * @param string $password Password to be Authentication
     *
     * @return $this
     */
    public function setDigestAuthentication($username = '', $password = '');

    /**
     * Function getHttpCode
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:15
     *
     * @return mixed
     */
    public function getHttpCode();

    /**
     * Function getHttpMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:15
     *
     * @return mixed
     */
    public function getHttpMessage();

    /**
     * Function getErrorCode
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:15
     *
     * @return mixed
     */
    public function getErrorCode();

    /**
     * Function getRequestsHeader
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:15
     *
     * @return mixed
     */
    public function getRequestsHeader();

    /**
     * Function getResponseHeader
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 23:15
     *
     * @return mixed
     */
    public function getResponseHeader();

    /**
     * Function guzzlePhpRequest
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:54
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     *
     * @return mixed
     */
    public function guzzlePhpRequest($url = '', $data = array(), $method = 'GET');

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
    public function curlRequest($url = '', $data = array(), $method = 'GET');

    /******************************** Handle Send Request ********************************/
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
    public function sendRequest($url = '', $data = array(), $method = 'GET');

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
    public function xmlRequest($url = '', $data = '', $timeout = 60);

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
    public function jsonRequest($url = '', $data = array(), $timeout = 60);
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
    public function xmlGetValue($xml = '', $openTag = '', $closeTag = '');

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
    public function parseXmlDataRequest($resultXml = '');
}
