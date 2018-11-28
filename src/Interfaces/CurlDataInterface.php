<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/28/18
 * Time: 14:22
 */

namespace nguyenanhung\MyRequests\Interfaces;

/**
 * Interface CurlDataInterface
 *
 * @package   nguyenanhung\MyRequests\Interfaces
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface CurlDataInterface
{
    /**
     * Function setAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 13:59
     *
     * @param bool $authentication
     *
     * @return $this
     */
    public function setAuthentication($authentication = FALSE);

    /**
     * Function getAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 13:59
     *
     * @return int
     */
    public function getAuthentication();

    /**
     * Function setUsername
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:00
     *
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username = '');

    /**
     * Function getUsername
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:00
     *
     * @return string
     */
    public function getUsername();

    /**
     * Function setPassword
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:01
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password = '');

    /**
     * Function getPassword
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:00
     *
     * @return string
     */
    public function getPassword();

    /**
     * Function setUrl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:01
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url = '');

    /**
     * Function getUrl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:01
     *
     * @return string
     */
    public function getUrl();

    /**
     * Function setData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:06
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData($data = []);

    /**
     * Function getData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:06
     *
     * @return mixed
     */
    public function getData();

    /**
     * Function setTimeout
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:11
     *
     * @param int $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout = 60);

    /**
     * Function getTimeout
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:11
     *
     * @return int
     */
    public function getTimeout();

    /**
     * Function isPost
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:07
     *
     * @return $this
     */
    public function isPost();

    /**
     * Function isJson
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:08
     *
     * @return $this
     */
    public function isJson();

    /**
     * Function isXML
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:08
     *
     * @return $this
     */
    public function isXML();

    /**
     * Function setUserAgent
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:10
     *
     * @param string $userAgent
     *
     * @return $this
     */
    public function setUserAgent($userAgent = '');

    /**
     * Function getUserAgent
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:09
     *
     * @return string
     */
    public function getUserAgent();

    /**
     * Function setCookieFileLocation
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:10
     *
     * @param string $cookieFileLocation
     *
     * @return $this
     */
    public function setCookieFileLocation($cookieFileLocation = '');

    /**
     * Function getCookieFileLocation
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:10
     *
     * @return string
     */
    public function getCookieFileLocation();

    /**
     * Function setFollowLocation
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:12
     *
     * @param bool $followLocation
     *
     * @return $this
     */
    public function setFollowLocation($followLocation = TRUE);

    /**
     * Function getFollowLocation
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:12
     *
     * @return bool
     */
    public function getFollowLocation();

    /**
     * Function setMaxRedirect
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:14
     *
     * @param int $maxRedirect
     *
     * @return $this
     */
    public function setMaxRedirect($maxRedirect = 10);

    /**
     * Function getMaxRedirect
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:13
     *
     * @return int
     */
    public function getMaxRedirect();

    /**
     * Function setReferer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:16
     *
     * @param string $referer
     *
     * @return $this
     */
    public function setReferer($referer = '');

    /**
     * Function getReferer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:16
     *
     * @return string
     */
    public function getReferer();

    /**
     * Function setSession
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:17
     *
     * @param array $session
     *
     * @return $this
     */
    public function setSession($session = []);

    /**
     * Function getSession
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:17
     *
     * @return mixed
     */
    public function getSession();

    /**
     * Function setIncludeHeader
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:17
     *
     * @param bool $includeHeader
     *
     * @return $this
     */
    public function setIncludeHeader($includeHeader = TRUE);

    /**
     * Function getIncludeHeader
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:18
     *
     * @return bool
     */
    public function getIncludeHeader();

    /**
     * Function setBinaryTransfer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:19
     *
     * @param bool $binaryTransfer
     *
     * @return $this
     */
    public function setBinaryTransfer($binaryTransfer = TRUE);

    /**
     * Function isBinaryTransfer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:19
     *
     * @return bool
     */
    public function isBinaryTransfer();

    /**
     * Function setNoBody
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:19
     *
     * @param bool $noBody
     *
     * @return $this
     */
    public function setNoBody($noBody = TRUE);

    /**
     * Function getNoBody
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:19
     *
     * @return bool
     */
    public function getNoBody();

    /**
     * Function createCurl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 13:50
     *
     * @param string $url
     *
     * @return $this
     */
    public function createCurl($url = '');

    /**
     * Function __toString
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 13:48
     *
     * @return mixed
     */
    public function __toString();
}
