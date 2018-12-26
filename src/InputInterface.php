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
}
