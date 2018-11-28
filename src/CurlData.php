<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/28/18
 * Time: 14:21
 */

namespace nguyenanhung\MyRequests;

use nguyenanhung\MyRequests\Interfaces\CurlDataInterface;

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
     */
    public function __construct()
    {
    }

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
    public function setAuthentication($authentication = FALSE)
    {
        $this->authentication = $authentication;

        return $this;
    }

    /**
     * Function getAuthentication
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 13:59
     *
     * @return int
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }

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
    public function setUsername($username = '')
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Function getUsername
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:00
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

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
    public function setPassword($password = '')
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Function getPassword
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:00
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

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
    public function setUrl($url = '')
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Function getUrl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:01
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

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
    public function setData($data = [])
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Function getData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:06
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

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
    public function setTimeout($timeout = 60)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Function getTimeout
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:11
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Function isPost
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:07
     *
     * @return $this
     */
    public function isPost()
    {
        $this->isPost = TRUE;

        return $this;
    }

    /**
     * Function isJson
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:08
     *
     * @return $this
     */
    public function isJson()
    {
        $this->isJson = TRUE;

        return $this;
    }

    /**
     * Function isXML
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:08
     *
     * @return $this
     */
    public function isXML()
    {
        $this->isXML = TRUE;

        return $this;
    }

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
    public function setUserAgent($userAgent = '')
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Function getUserAgent
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:09
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

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
    public function setCookieFileLocation($cookieFileLocation = '')
    {
        $this->cookieFileLocation = $cookieFileLocation;

        return $this;
    }

    /**
     * Function getCookieFileLocation
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:10
     *
     * @return string
     */
    public function getCookieFileLocation()
    {
        return $this->cookieFileLocation;
    }

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
    public function setFollowLocation($followLocation = TRUE)
    {
        $this->followLocation = $followLocation;

        return $this;
    }

    /**
     * Function getFollowLocation
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:12
     *
     * @return bool
     */
    public function getFollowLocation()
    {
        return $this->followLocation;
    }

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
    public function setMaxRedirect($maxRedirect = 10)
    {
        $this->maxRedirect = $maxRedirect;

        return $this;
    }

    /**
     * Function getMaxRedirect
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:13
     *
     * @return int
     */
    public function getMaxRedirect()
    {
        return $this->maxRedirect;
    }

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
    public function setReferer($referer = '')
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Function getReferer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:16
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

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
    public function setSession($session = [])
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Function getSession
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:17
     *
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

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
    public function setIncludeHeader($includeHeader = TRUE)
    {
        $this->includeHeader = $includeHeader;

        return $this;
    }

    /**
     * Function getIncludeHeader
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:18
     *
     * @return bool
     */
    public function getIncludeHeader()
    {
        return $this->includeHeader;
    }

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
    public function setBinaryTransfer($binaryTransfer = TRUE)
    {
        $this->binaryTransfer = $binaryTransfer;

        return $this;
    }

    /**
     * Function isBinaryTransfer
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:19
     *
     * @return bool
     */
    public function isBinaryTransfer()
    {
        return $this->binaryTransfer;
    }

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
    public function setNoBody($noBody = TRUE)
    {
        $this->noBody = $noBody;

        return $this;
    }

    /**
     * Function getNoBody
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 14:19
     *
     * @return bool
     */
    public function getNoBody()
    {
        return $this->noBody;
    }

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
        if ($this->authentication == 1) {
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
        $this->http_error_message = $this->error ? (isset($this->response_headers['0']) ? $this->response_headers['0'] : '') : '';
        $this->error_message      = $this->curl_error ? $this->curl_error_message : $this->http_error_message;
        curl_close($curl);

        return $this;
    }

    /**
     * Function __toString
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/28/18 13:48
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->response;
    }
}
