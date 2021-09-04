<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/18/18
 * Time: 10:47
 */

namespace nguyenanhung\MyRequests;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class Input
 *
 * Class được kế thừa từ thư viện HttpFoundation
 *
 * @see        https://symfony.com/doc/current/components/http_foundation.html
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class Input implements InputInterface
{
    /** @var object khởi tạo đối tượng đến class \Symfony\Component\HttpFoundation\Request */
    protected $input;
    /** @var object khởi tạo đối tượng đến class \nguyenanhung\MyRequests\Ip */
    protected $ip;

    /**
     * Raw input stream data
     *
     * Holds a cache of php://input contents
     *
     * @var    string
     */
    protected $rawInputStream;

    /**
     * Parsed input stream data
     *
     * Parsed from php://input at runtime
     *
     * @var    array
     */
    protected $inputStream;

    /**
     * Enable XSS flag
     *
     * Determines whether the XSS filter is always active when
     * GET, POST or COOKIE data is encountered.
     * Set automatically based on config setting.
     *
     * @var    bool
     */
    protected $enableXss = false;

    /**
     * List of all HTTP request headers
     *
     * @var array
     */
    protected $headers = array();

    /**
     * Input constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        $this->input = Request::createFromGlobals();
        $this->ip    = new Ip();
    }

    /**
     * Function rawInputStream
     *
     * @return $this|\nguyenanhung\MyRequests\Input
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 03/18/2021 59:59
     */
    public function rawInputStream()
    {
        $rawInputStream       = file_get_contents('php://input');
        $this->rawInputStream = $rawInputStream;

        return $this;
    }

    /**
     * Function getRawInputStream
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/04/2021 14:38
     */
    public function getRawInputStream()
    {
        return $this->rawInputStream;
    }

    /**
     * Function inputStream
     *
     * @param null $index
     * @param null $xss_clean
     *
     * @return array|mixed|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 03/18/2021 00:18
     */
    public function inputStream($index = null, $xss_clean = null)
    {
        // Prior to PHP 5.6, the input stream can only be read once,
        // so we'll need to check if we have already done that first.
        if (!is_array($this->inputStream)) {
            // $this->raw_input_stream will trigger __get().
            parse_str($this->rawInputStream, $this->inputStream);
            is_array($this->inputStream) or $this->inputStream = array();
        }

        return $this->fetchFromArray($this->inputStream, $index, $xss_clean);
    }

    /**
     * Function method - Hàm lấy thông tin Request Method
     *
     * @param false $upper Whether to return in upper or lower case (default: FALSE)
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 03/18/2021 00:27
     */
    public function method($upper = false)
    {
        return ($upper)
            ? strtoupper($this->server('REQUEST_METHOD', true))
            : strtolower($this->server('REQUEST_METHOD', true));
    }

    /**
     * Hàm lấy dữ liệu từ $_POST
     *
     * @param string|mixed $key       POST parameter name
     * @param bool         $xss_clean Whether to apply XSS filtering
     *
     * @return bool|float|int|mixed|string|string[]|null $_POST if no parameters supplied, otherwise the POST value if found or NULL if not
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/18/18 10:58
     *
     */
    public function post($key = '', $xss_clean = false)
    {
        if ($this->input->request->has($key)) {
            $content = $this->input->request->get($key);
            if ($xss_clean === true) {
                $content = Utils::xssClean($content);
            }

            return $content;
        }

        return null;
    }

    /**
     * Hàm lấy dữ liệu từ $_GET
     *
     * @param string|mixed $key       GET parameter name
     * @param bool         $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_GET if no parameters supplied, otherwise the GET value if found or NULL if not
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/18/18 10:58
     *
     */
    public function get($key = '', $xss_clean = false)
    {
        if ($this->input->query->has($key)) {
            $content = $this->input->query->get($key);
            if ($xss_clean === true) {
                $content = Utils::xssClean($content);
            }

            return $content;
        }

        return null;
    }

    /**
     * Hàm lấy dữ liệu từ $_SERVER
     *
     * @param string|mixed $key       SERVER parameter name
     * @param bool         $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_SERVER f no parameters supplied, otherwise the SERVER value if found or NULL if not
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/18/18 10:58
     *
     */
    public function server($key = '', $xss_clean = false)
    {
        if ($this->input->server->has($key)) {
            $content = $this->input->server->get($key);
            if ($xss_clean === true) {
                $content = Utils::xssClean($content);
            }

            return $content;
        }

        return null;
    }

    /**
     * Hàm lấy dữ liệu từ $_COOKIE
     *
     * @param string|mixed $key       COOKIE parameter name
     * @param bool         $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_COOKIE f no parameters supplied, otherwise the COOKIE value if found or NULL if not
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/18/18 10:58
     *
     */
    public function cookie($key = '', $xss_clean = false)
    {
        if ($this->input->cookies->has($key)) {
            $content = $this->input->cookies->get($key);
            if ($xss_clean === true) {
                $content = Utils::xssClean($content);
            }

            return $content;
        }

        return null;
    }

    /**
     * Hàm lấy dữ liệu từ $_FILES
     *
     * @param string|mixed $key       FILES parameter name
     * @param bool         $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_FILES f no parameters supplied, otherwise the FILES value if found or NULL if not
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/18/18 10:58
     *
     */
    public function file($key = '', $xss_clean = false)
    {
        if ($this->input->files->has($key)) {
            $content = $this->input->files->get($key);
            if ($xss_clean === true) {
                $content = Utils::xssClean($content);
            }

            return $content;
        }

        return null;
    }

    /**
     * Hàm lấy dữ liệu từ $_SERVER Header
     *
     * @param string|mixed $key       _SERVER parameter name
     * @param bool         $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_SERVER f no parameters supplied, otherwise the _SERVER value if found or NULL if not
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/18/18 10:58
     *
     */
    public function header($key = '', $xss_clean = false)
    {
        if ($this->input->headers->has($key)) {
            $content = $this->input->headers->get($key);
            if ($xss_clean === true) {
                $content = Utils::xssClean($content);
            }

            return $content;
        }

        return null;
    }

    /**
     * Hàm lấy địa chỉ IP của người dùng
     *
     * @return bool|int|mixed|string
     * @author    : 713uk13m <dev@nguyenanhung.com>
     * @copyright : 713uk13m <dev@nguyenanhung.com>
     * @time      : 10/18/18 11:41
     *
     */
    public function ip_address()
    {
        return $this->ip->getIpAddress();
    }

    /**
     * Request Headers
     *
     * @param bool $xss_clean Whether to apply XSS filtering
     *
     * @return    array
     */
    public function requestHeaders($xss_clean = false)
    {
        // If header is already defined, return it immediately
        if (!empty($this->headers)) {
            return $this->fetchFromArray($this->headers, null, $xss_clean);
        }

        // In Apache, you can simply call apache_request_headers()
        if (function_exists('apache_request_headers')) {
            $this->headers = apache_request_headers();
        } else {
            isset($_SERVER['CONTENT_TYPE']) && $this->headers['Content-Type'] = $_SERVER['CONTENT_TYPE'];
            foreach ($_SERVER as $key => $val) {
                if (sscanf($key, 'HTTP_%s', $header) === 1) {
                    // take SOME_HEADER and turn it into Some-Header
                    $header                 = str_replace('_', ' ', strtolower($header));
                    $header                 = str_replace(' ', '-', ucwords($header));
                    $this->headers[$header] = $val;
                }
            }
        }

        return $this->fetchFromArray($this->headers, null, $xss_clean);
    }

    /**
     * Get Request Header
     *
     * Returns the value of a single member of the headers class member
     *
     * @param string $index     Header name
     * @param bool   $xss_clean Whether to apply XSS filtering
     *
     * @return    string|null    The requested header on success or NULL on failure
     */
    public function getRequestHeader($index, $xss_clean = false)
    {
        static $headers;
        if (!isset($headers)) {
            empty($this->headers) && $this->requestHeaders();
            foreach ($this->headers as $key => $value) {
                $headers[strtolower($key)] = $value;
            }
        }
        $index = strtolower($index);
        if (!isset($headers[$index])) {
            return null;
        }

        return ($xss_clean === true)
            ? Utils::xssClean($headers[$index])
            : $headers[$index];
    }

    /**
     * Is AJAX request?
     *
     * Test to see if a request contains the HTTP_X_REQUESTED_WITH header.
     *
     * @return    bool
     */
    public function isAjax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

    /**
     * Is CLI request?
     *
     * Test to see if a request was made from the command line.
     *
     * @return    bool
     */
    public function isCLI()
    {
        return (PHP_SAPI === 'cli' or defined('STDIN'));
    }

    /**
     * Fetch from Array
     *
     * Internal method used to retrieve values from global arrays.
     *
     * @param array    &$array     $_GET, $_POST, $_COOKIE, $_SERVER, etc.
     * @param mixed     $index     Index for item to be fetched from $array
     * @param bool      $xss_clean Whether to apply XSS filtering
     *
     * @return    mixed
     * @copyright CodeIgniter
     *
     */
    public function fetchFromArray(&$array, $index = null, $xss_clean = null)
    {
        is_bool($xss_clean) or $xss_clean = $this->enableXss;

        // If $index is NULL, it means that the whole $array is requested
        isset($index) or $index = array_keys($array);

        // allow fetching multiple keys at once
        if (is_array($index)) {
            $output = array();
            foreach ($index as $key) {
                $output[$key] = $this->fetchFromArray($array, $key, $xss_clean);
            }

            return $output;
        }
        $patternArray = '/(?:^[^\[]+)|\[[^]]*\]/'; // Does the index contain array notation
        if (isset($array[$index])) {
            $value = $array[$index];
        } elseif (($count = preg_match_all($patternArray, $index, $matches)) > 1) {
            $value = $array;
            for ($i = 0; $i < $count; $i++) {
                $key = trim($matches[0][$i], '[]');
                if ($key === '') // Empty notation will return the value as array
                {
                    break;
                }
                if (isset($value[$key])) {
                    $value = $value[$key];
                } else {
                    return null;
                }
            }
        } else {
            return null;
        }

        return ($xss_clean === true)
            ? Utils::xssClean($value)
            : $value;
    }
}
