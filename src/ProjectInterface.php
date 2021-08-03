<?php
/**
 * Project requests
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:55
 */

namespace nguyenanhung\MyRequests;

/**
 * Interface ProjectInterface
 *
 * @package   nguyenanhung\MyRequests
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface ProjectInterface
{
    const VERSION         = '2.0.4';
    const LAST_MODIFIED   = '2021-08-03';
    const MIN_PHP_VERSION = '7.0';
    const GET             = 'GET';
    const HEAD            = 'HEAD';
    const DELETE          = 'DELETE';
    const TRACE           = 'TRACE';
    const POST            = 'POST';
    const PUT             = 'PUT';
    const OPTIONS         = 'OPTIONS';
    const PATCH           = 'PATCH';
    const ENCODING        = "utf-8";
    const MAX_REDIRECT    = 10;
    const RETURN_TRANSFER = TRUE;
    const FOLLOW_LOCATION = TRUE;
    const USE_BENCHMARK   = FALSE;

    /**
     * Hàm lấy phiên bản hiện tại của Package
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:05
     *
     * @return mixed Phiên bản hiện tại của Package, VD: 0.1.1
     */
    public function getVersion();
}
