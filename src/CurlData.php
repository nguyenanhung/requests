<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/28/18
 * Time: 14:21
 */

namespace nguyenanhung\MyRequests;

/**
 * Class CurlData
 *
 * @package   nguyenanhung\MyRequests
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class CurlData implements CurlDataInterface
{
    /** @var bool Set Authentication */
    protected $authentication = FALSE;
    /** @var string Username */
    protected $username = '';
    /** @var string Password */
    protected $password = '';
    /** @var string URL */
    protected $url;
    /** @var null|array|string Data to Send Request */
    protected $data;
    /** @var int Timeout to Request */
    protected $timeout;
    /** @var bool Set is POST */
    protected $isPost;
    /** @var bool Set is JSON */
    protected $isJson;
    /** @var bool Set is XML */
    protected $isXML;
    /** @var string User Agent */
    protected $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36';
    /** @var string Cookie File Location */
    protected $cookieFileLocation;
    /** @var bool Set Follow Location */
    protected $followLocation;
    /** @var int Set Max Redirect */
    protected $maxRedirect;
    /** @var string Referer URL */
    protected $referer;
    /** @var null|array|string Session Data */
    protected $session;
    /** @var bool Include Header */
    protected $includeHeader;
    /** @var bool No Body */
    protected $noBody;
    /** @var bool Binary Transfer */
    protected $binaryTransfer;
    public    $status;
    public    $response;
    public    $request_headers;
    public    $response_headers;
    public    $curl_error;
    public    $curl_error_code;
    public    $curl_error_message;
    public    $http_error;
    public    $http_status_code;
    public    $http_error_message;
    public    $error;
    public    $error_code;
    public    $error_message;

    /**
     * CurlData constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
    }

    /**
     * Function __toString
     *
     * @return mixed
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 56:23
     */
    public function __toString()
    {
        return $this->response;
    }

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
    public function setAuthentication($authentication = FALSE)
    {
        $this->authentication = $authentication;

        return $this;
    }

    /**
     * Function getAuthentication
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:08
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }

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
    public function setUsername($username = '')
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Function getUsername
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:19
     */
    public function getUsername()
    {
        return $this->username;
    }

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
    public function setPassword($password = '')
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Function getPassword
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:29
     */
    public function getPassword()
    {
        return $this->password;
    }

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
    public function setUrl($url = '')
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Function getUrl
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:35
     */
    public function getUrl()
    {
        return $this->url;
    }

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
    public function setData($data = array())
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Function getData
     *
     * @return array|string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:42
     */
    public function getData()
    {
        return $this->data;
    }

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
    public function setTimeout($timeout = 60)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Function getTimeout
     *
     * @return int
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:47
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Function isPost
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 54:51
     */
    public function isPost()
    {
        $this->isPost = TRUE;

        return $this;
    }

    /**
     * Function isJson
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:02
     */
    public function isJson()
    {
        $this->isJson = TRUE;

        return $this;
    }

    /**
     * Function isXML
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:05
     */
    public function isXML()
    {
        $this->isXML = TRUE;

        return $this;
    }

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
    public function setUserAgent($userAgent = '')
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Function getUserAgent
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:12
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

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
    public function setCookieFileLocation($cookieFileLocation = '')
    {
        $this->cookieFileLocation = $cookieFileLocation;

        return $this;
    }

    /**
     * Function getCookieFileLocation
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:18
     */
    public function getCookieFileLocation()
    {
        return $this->cookieFileLocation;
    }

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
    public function setFollowLocation($followLocation = TRUE)
    {
        $this->followLocation = $followLocation;

        return $this;
    }

    /**
     * Function getFollowLocation
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:25
     */
    public function getFollowLocation()
    {
        return $this->followLocation;
    }

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
    public function setMaxRedirect($maxRedirect = 10)
    {
        $this->maxRedirect = $maxRedirect;

        return $this;
    }

    /**
     * Function getMaxRedirect
     *
     * @return int
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:34
     */
    public function getMaxRedirect()
    {
        return $this->maxRedirect;
    }

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
    public function setReferer($referer = '')
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Function getReferer
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:42
     */
    public function getReferer()
    {
        return $this->referer;
    }

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
    public function setSession($session = array())
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Function getSession
     *
     * @return array|string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:47
     */
    public function getSession()
    {
        return $this->session;
    }

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
    public function setIncludeHeader($includeHeader = TRUE)
    {
        $this->includeHeader = $includeHeader;

        return $this;
    }

    /**
     * Function getIncludeHeader
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 55:57
     */
    public function getIncludeHeader()
    {
        return $this->includeHeader;
    }

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
    public function setBinaryTransfer($binaryTransfer = TRUE)
    {
        $this->binaryTransfer = $binaryTransfer;

        return $this;
    }

    /**
     * Function isBinaryTransfer
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 56:03
     */
    public function isBinaryTransfer()
    {
        return $this->binaryTransfer;
    }

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
    public function setNoBody($noBody = TRUE)
    {
        $this->noBody = $noBody;

        return $this;
    }

    /**
     * Function getNoBody
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 56:14
     */
    public function getNoBody()
    {
        return $this->noBody;
    }

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
    public function createCurl($url = '')
    {
        if (!empty($url)) {
            $this->url = $url;
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_MAXREDIRS, $this->maxRedirect);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, $this->followLocation);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookieFileLocation);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFileLocation);
        if ($this->authentication) {
            curl_setopt($curl, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        }
        if ($this->includeHeader) {
            curl_setopt($curl, CURLOPT_HEADER, TRUE);
        }
        if ($this->isPost) {
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
        }
        if ($this->isJson) {
            $header[] = 'Accept: application/json';
            curl_setopt($curl, CURLOPT_HEADER, $header[]);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->data));
        }
        if ($this->isXML) {
            $header[] = 'Accept: text/xml';
            curl_setopt($curl, CURLOPT_HEADER, $header[]);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
        }
        if ($this->noBody) {
            curl_setopt($curl, CURLOPT_NOBODY, TRUE);
        }
        if ($this->referer) {
            curl_setopt($curl, CURLOPT_REFERER, $this->referer);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
        $this->response_headers   = array();
        $this->response           = curl_exec($curl);
        $this->status             = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->curl_error_code    = curl_errno($curl);
        $this->curl_error_message = curl_error($curl);
        $this->curl_error         = !($this->curl_error_code === 0);
        $this->http_status_code   = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->http_error         = in_array(floor($this->http_status_code / 100), array(4, 5));
        $this->error              = $this->curl_error || $this->http_error;
        $this->error_code         = $this->error ? ($this->curl_error ? $this->curl_error_code : $this->http_status_code) : 0;
        $this->request_headers    = preg_split('/\r\n/', curl_getinfo($curl, CURLINFO_HEADER_OUT), NULL, PREG_SPLIT_NO_EMPTY);
        if (isset($this->response_headers['0'])) {
            $this->http_error_message = $this->error ? ($this->response_headers['0']) : '';
        } else {
            $this->http_error_message = $this->error ? ('') : '';
        }
        $this->error_message      = $this->curl_error ? $this->curl_error_message : $this->http_error_message;
        curl_close($curl);

        return $this;
    }
}
