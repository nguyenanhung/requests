<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/18/18
 * Time: 11:12
 */

namespace nguyenanhung\MyRequests;

/**
 * Interface InputInterface
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface InputInterface
{
    /**
     * Function rawInputStream
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2018-12-26 14:25
     *
     * @return $this
     */
    public function rawInputStream();

    /**
     * Function getRawInputStream
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2018-12-26 14:25
     *
     * @return mixed
     */
    public function getRawInputStream();

    /**
     * Function inputStream
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2018-12-26 14:32
     *
     * @param null $index
     * @param null $xss_clean
     *
     * @return mixed
     */
    public function inputStream($index = NULL, $xss_clean = NULL);

    /**
     * Hàm lấy thông tin Request Method
     *
     * Return the request method
     *
     * @param    bool $upper Whether to return in upper or lower case
     *                       (default: FALSE)
     *
     * @return    string
     */
    public function method($upper = FALSE);

    /**
     * Hàm lấy dữ liệu từ $_POST
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 10:58
     *
     * @param string $key       POST parameter name
     * @param bool   $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_POST if no parameters supplied, otherwise the POST value if found or NULL
     *                                    if not
     */
    public function post($key = '', $xss_clean = FALSE);

    /**
     * Hàm lấy dữ liệu từ $_GET
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 10:58
     *
     * @param string $key       GET parameter name
     * @param bool   $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_GET if no parameters supplied, otherwise the GET value if found or NULL
     *                                    if not
     */
    public function get($key = '', $xss_clean = FALSE);

    /**
     * Hàm lấy dữ liệu từ $_SERVER
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 10:58
     *
     * @param string $key       SERVER parameter name
     * @param bool   $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_SERVER f no parameters supplied, otherwise the SERVER value if found or NULL
     *                                    if not
     */
    public function server($key = '', $xss_clean = FALSE);

    /**
     * Hàm lấy dữ liệu từ $_COOKIE
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 10:58
     *
     * @param string $key       COOKIE parameter name
     * @param bool   $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_COOKIE f no parameters supplied, otherwise the COOKIE value if found or NULL
     *                                    if not
     */
    public function cookie($key = '', $xss_clean = FALSE);

    /**
     * Hàm lấy dữ liệu từ $_FILES
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 10:58
     *
     * @param string $key       FILES parameter name
     * @param bool   $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_FILES f no parameters supplied, otherwise the FILES value if found or NULL
     *                                    if not
     */
    public function file($key = '', $xss_clean = FALSE);

    /**
     * Hàm lấy dữ liệu từ $_SERVER Header
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 10:58
     *
     * @param string $key       _SERVER parameter name
     * @param bool   $xss_clean Whether to apply XSS filtering
     *
     * @return mixed|null|string|string[] $_SERVER f no parameters supplied, otherwise the _SERVER value if found or
     *                                    NULL if not
     */
    public function header($key = '', $xss_clean = FALSE);

    /**
     * Hàm lấy địa chỉ IP của người dùng
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:41
     *
     * @return bool|int|mixed|string
     */
    public function ip_address();

    // -------------------------------------------------------------------- //

    /**
     * Request Headers
     *
     * @param    bool $xss_clean Whether to apply XSS filtering
     *
     * @return    array
     */
    public function requestHeaders($xss_clean = FALSE);

    /**
     * Get Request Header
     *
     * Returns the value of a single member of the headers class member
     *
     * @param    string $index     Header name
     * @param    bool   $xss_clean Whether to apply XSS filtering
     *
     * @return    string|null    The requested header on success or NULL on failure
     */
    public function getRequestHeader($index, $xss_clean = FALSE);

    /**
     * Is AJAX request?
     *
     * Test to see if a request contains the HTTP_X_REQUESTED_WITH header.
     *
     * @return    bool
     */
    public function isAjax();

    /**
     * Is CLI request?
     *
     * Test to see if a request was made from the command line.
     *
     * @return    bool
     */
    public function isCLI();

    // -------------------------------------------------------------------- //

    /**
     * Fetch from Array
     *
     * Internal method used to retrieve values from global arrays.
     *
     * @copyright CodeIgniter
     *
     * @param    array    &$array     $_GET, $_POST, $_COOKIE, $_SERVER, etc.
     * @param    mixed     $index     Index for item to be fetched from $array
     * @param    bool      $xss_clean Whether to apply XSS filtering
     *
     * @return    mixed
     */
    public function fetchFromArray(&$array, $index = NULL, $xss_clean = NULL);
}
