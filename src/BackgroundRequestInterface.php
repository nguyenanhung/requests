<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/16/18
 * Time: 17:05
 */

namespace nguyenanhung\MyRequests;

/**
 * Interface BackgroundRequestInterface
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface BackgroundRequestInterface
{
    /**
     * Hàm gọi 1 async GET Request để không delay Main Process
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:15
     *
     * @param string $url Url Endpoint
     *
     * @return bool TRUE nếu thành công, FALSE nếu thất bại
     */
    public static function backgroundHttpGet($url);

    /**
     * Hàm gọi 1 async POST Request để không delay Main Process
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:16
     *
     * @param string $url         Url Endpoint
     * @param string $paramString Params to Request
     *
     * @return bool TRUE nếu thành công, FALSE nếu thất bại
     */
    public static function backgroundHttpPost($url, $paramString = '');
}
