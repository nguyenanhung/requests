<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 03:45
 */

namespace nguyenanhung\MyRequests\Interfaces;


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
     * @return mixed
     */
    public function setHeader($headers = []);

    /**
     * Function setCookie
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param array $cookies
     *
     * @return mixed
     */
    public function setCookie($cookies = []);

    /**
     * Function setOptions
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param array $options
     *
     * @return mixed
     */
    public function setOptions($options = []);

    /**
     * Function setTimeout
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param int $timeout
     *
     * @return mixed
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
     * @return mixed
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
     * @return mixed
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
     * @return mixed
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
     * @return mixed
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
     * @return mixed
     */
    public function setRequestIsJson($isJson = FALSE);

    /**
     * Function setBasicAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param string $username
     * @param string $password
     *
     * @return mixed
     */
    public function setBasicAuthentication($username = '', $password = '');

    /**
     * Function setDigestAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:53
     *
     * @param string $username
     * @param string $password
     *
     * @return mixed
     */
    public function setDigestAuthentication($username = '', $password = '');

    /**
     * Function pyRequest
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
    public function pyRequest($url = '', $data = [], $method = 'GET');

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
    public function guzzlePhpRequest($url = '', $data = [], $method = 'GET');

    /**
     * Function curlRequest
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
    public function curlRequest($url = '', $data = [], $method = 'GET');

    /**
     * Function sendRequest
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:14
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     *
     * @return mixed
     */
    public function sendRequest($url = '', $data = [], $method = 'GET');

    /**
     * Function xmlRequest
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:14
     *
     * @param string $url
     * @param array  $data
     * @param int    $timeout
     *
     * @return mixed
     */
    public function xmlRequest($url = '', $data = [], $timeout = 60);

    /**
     * Function jsonRequest
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 07:13
     *
     * @param string $url
     * @param array  $data
     * @param int    $timeout
     *
     * @return mixed
     */
    public function jsonRequest($url = '', $data = [], $timeout = 60);

    /**
     * Function xmlGetValue
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:58
     *
     * @param string $xml
     * @param string $openTag
     * @param string $closeTag
     *
     * @return mixed
     */
    public function xmlGetValue($xml = '', $openTag = '', $closeTag = '');

    /**
     * Function parseXmlDataRequest
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 06:58
     *
     * @param string $resultXml
     *
     * @return mixed
     */
    public function parseXmlDataRequest($resultXml = '');
}
