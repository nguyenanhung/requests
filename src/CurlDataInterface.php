<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/28/18
 * Time: 14:22
 */

namespace nguyenanhung\MyRequests;

/**
 * Interface CurlDataInterface
 *
 * @package   nguyenanhung\MyRequests
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface CurlDataInterface
{
    /**
     * Function setAuthentication
     *
     * @param bool $authentication
     *
     * @return $this|\nguyenanhung\MyRequests\CurlDataInterface
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 53:36
     */
    public function setAuthentication($authentication = FALSE);

    /**
     * Function getAuthentication
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:08
     */
    public function getAuthentication();

    /**
     * Function setUsername
     *
     * @param string $username
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:11
     */
    public function setUsername($username = '');

    /**
     * Function getUsername
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:19
     */
    public function getUsername();

    /**
     * Function setPassword
     *
     * @param string $password
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:25
     */
    public function setPassword($password = '');

    /**
     * Function getPassword
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:29
     */
    public function getPassword();

    /**
     * Function setUrl
     *
     * @param string $url
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:32
     */
    public function setUrl($url = '');

    /**
     * Function getUrl
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:35
     */
    public function getUrl();

    /**
     * Function setData
     *
     * @param array|mixed $data
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:38
     */
    public function setData($data = array());

    /**
     * Function getData
     *
     * @return array|string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:42
     */
    public function getData();

    /**
     * Function setTimeout
     *
     * @param int $timeout
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:45
     */
    public function setTimeout($timeout = 60);

    /**
     * Function getTimeout
     *
     * @return int
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:47
     */
    public function getTimeout();

    /**
     * Function isPost
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:51
     */
    public function isPost();

    /**
     * Function isJson
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:02
     */
    public function isJson();

    /**
     * Function isXML
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:05
     */
    public function isXML();

    /**
     * Function setUserAgent
     *
     * @param string $userAgent
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:09
     */
    public function setUserAgent($userAgent = '');

    /**
     * Function getUserAgent
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:12
     */
    public function getUserAgent();

    /**
     * Function setCookieFileLocation
     *
     * @param string $cookieFileLocation
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:15
     */
    public function setCookieFileLocation($cookieFileLocation = '');

    /**
     * Function getCookieFileLocation
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:18
     */
    public function getCookieFileLocation();

    /**
     * Function setFollowLocation
     *
     * @param bool $followLocation
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:21
     */
    public function setFollowLocation($followLocation = TRUE);

    /**
     * Function getFollowLocation
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:25
     */
    public function getFollowLocation();

    /**
     * Function setMaxRedirect
     *
     * @param int $maxRedirect
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:29
     */
    public function setMaxRedirect($maxRedirect = 10);

    /**
     * Function getMaxRedirect
     *
     * @return int
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:34
     */
    public function getMaxRedirect();

    /**
     * Function setReferer
     *
     * @param string $referer
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:38
     */
    public function setReferer($referer = '');

    /**
     * Function getReferer
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:42
     */
    public function getReferer();

    /**
     * Function setSession
     *
     * @param array|mixed $session
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:44
     */
    public function setSession($session = array());

    /**
     * Function getSession
     *
     * @return array|string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:47
     */
    public function getSession();

    /**
     * Function setIncludeHeader
     *
     * @param bool $includeHeader
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:51
     */
    public function setIncludeHeader($includeHeader = TRUE);

    /**
     * Function getIncludeHeader
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:57
     */
    public function getIncludeHeader();

    /**
     * Function setBinaryTransfer
     *
     * @param bool $binaryTransfer
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 56:00
     */
    public function setBinaryTransfer($binaryTransfer = TRUE);

    /**
     * Function isBinaryTransfer
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 56:03
     */
    public function isBinaryTransfer();

    /**
     * Function setNoBody
     *
     * @param bool $noBody
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 56:10
     */
    public function setNoBody($noBody = TRUE);

    /**
     * Function getNoBody
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 56:14
     */
    public function getNoBody();

    /**
     * Function createCurl
     *
     * @param string $url
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 56:20
     */
    public function createCurl($url = '');
}
