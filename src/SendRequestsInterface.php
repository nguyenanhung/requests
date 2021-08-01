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
     * @param array $headers
     *
     * @return $this|\nguyenanhung\MyRequests\MyRequests
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 01/21/2021 09:44
     */
    public function setHeader($headers = array());

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
    public function setCookie($cookies = array());

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
    public function setOptions($options = array());

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
    public function setTimeout($timeout = 60);

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
    public function setUserAgent($userAgent = '');

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
    public function setReferrer($referrer = '');

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
    public function setUserBody($isBody = FALSE);

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
    public function setRequestIsXml($isXml = FALSE);

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
    public function setRequestIsJson($isJson = FALSE);

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
    public function setRequestIsSSL($isSSL = FALSE);

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
    public function setErrorResponseIsData($errorResponseIsData = FALSE);

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
    public function setErrorResponseIsNull($errorResponseIsNull = FALSE);

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
    public function setBasicAuthentication($username = '', $password = '');

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
    public function setDigestAuthentication($username = '', $password = '');

    /**
     * Function getHttpCode
     *
     * @return int
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:11
     */
    public function getHttpCode();

    /**
     * Function getHttpMessage
     *
     * @return string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:09
     */
    public function getHttpMessage();

    /**
     * Function getErrorCode
     *
     * @return int
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:06
     */
    public function getErrorCode();

    /**
     * Function getRequestsHeader
     *
     * @return array|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:04
     */
    public function getRequestsHeader();

    /**
     * Function getResponseHeader
     *
     * @return array|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/01/2021 12:01
     */
    public function getResponseHeader();

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
    public function guzzlePhpRequest($url = '', $data = array(), $method = 'GET');

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
    public function curlRequest($url = '', $data = array(), $method = 'GET');

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
     * @param string $url     URL Endpoint to be Request
     * @param string $data    Data Content to be Request
     * @param int    $timeout Timeout Request
     *
     * @return array|null|string Response from Server
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:11
     *
     */
    public function xmlRequest($url = '', $data = '', $timeout = 60);

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
    public function jsonRequest($url = '', $data = array(), $timeout = 60);

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
    public function xmlGetValue($xml = '', $openTag = '', $closeTag = '');

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
    public function parseXmlDataRequest($resultXml = '');
}
