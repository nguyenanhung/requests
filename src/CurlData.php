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
class CurlData
{
    /** @var bool Set Authentication */
    protected $authentication = false;
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
    /** @var bool NoBody */
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
     * @param false $authentication
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/20/2021 16:42
     */
    public function setAuthentication(bool $authentication = false): self
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
    public function getAuthentication(): bool
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
    public function setUsername(string $username = ''): self
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
    public function getUsername(): string
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
    public function setPassword(string $password = ''): self
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
    public function getPassword(): string
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
    public function setUrl(string $url = ''): self
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
    public function getUrl(): string
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
    public function setData($data = array()): self
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
    public function setTimeout(int $timeout = 60): self
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
    public function getTimeout(): int
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
    public function isPost(): self
    {
        $this->isPost = true;

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
    public function isJson(): self
    {
        $this->isJson = true;

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
    public function isXML(): self
    {
        $this->isXML = true;

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
    public function setUserAgent(string $userAgent = ''): self
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
    public function getUserAgent(): string
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
    public function setCookieFileLocation(string $cookieFileLocation = ''): self
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
    public function getCookieFileLocation(): string
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
    public function setFollowLocation(bool $followLocation = true): self
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
    public function getFollowLocation(): bool
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
    public function setMaxRedirect(int $maxRedirect = 10): self
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
    public function getMaxRedirect(): int
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
    public function setReferer(string $referer = ''): self
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
    public function getReferer(): string
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
    public function setSession($session = array()): self
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
    public function setIncludeHeader(bool $includeHeader = true): self
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
    public function getIncludeHeader(): bool
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
    public function setBinaryTransfer(bool $binaryTransfer = true): self
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
    public function isBinaryTransfer(): bool
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
    public function setNoBody(bool $noBody = true): self
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
    public function getNoBody(): bool
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
    public function createCurl(string $url = ''): self
    {
        if (!empty($url)) {
            $this->url = $url;
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_MAXREDIRS, $this->maxRedirect);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, $this->followLocation);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookieFileLocation);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFileLocation);
        if ($this->authentication) {
            curl_setopt($curl, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        }
        if ($this->includeHeader) {
            curl_setopt($curl, CURLOPT_HEADER, true);
        }
        if ($this->isPost) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
        }
        if ($this->isJson) {
            $header[] = 'Accept: application/json';
            curl_setopt($curl, CURLOPT_HEADER, $header[]);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->data));
        }
        if ($this->isXML) {
            $header[] = 'Accept: text/xml';
            curl_setopt($curl, CURLOPT_HEADER, $header[]);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
        }
        if ($this->noBody) {
            curl_setopt($curl, CURLOPT_NOBODY, true);
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
        $this->http_error         = in_array(floor($this->http_status_code / 100), array(4, 5), true);
        $this->error              = $this->curl_error || $this->http_error;
        $this->error_code         = $this->error ? ($this->curl_error ? $this->curl_error_code : $this->http_status_code) : 0;
        $this->request_headers    = preg_split('/\r\n/', curl_getinfo($curl, CURLINFO_HEADER_OUT), null, PREG_SPLIT_NO_EMPTY);
        if (isset($this->response_headers['0'])) {
            $this->http_error_message = $this->error ? ($this->response_headers['0']) : '';
        } else {
            $this->http_error_message = $this->error ? ('') : '';
        }
        $this->error_message = $this->curl_error ? $this->curl_error_message : $this->http_error_message;
        curl_close($curl);

        return $this;
    }
}
