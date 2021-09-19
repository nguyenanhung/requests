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
    public const VERSION         = '3.0.2';
    public const LAST_MODIFIED   = '2021-09-20';
    public const MIN_PHP_VERSION = '7.1';
    public const GET             = 'GET';
    public const HEAD            = 'HEAD';
    public const DELETE          = 'DELETE';
    public const TRACE           = 'TRACE';
    public const POST            = 'POST';
    public const PUT             = 'PUT';
    public const OPTIONS         = 'OPTIONS';
    public const PATCH           = 'PATCH';
    public const ENCODING        = "utf-8";
    public const MAX_REDIRECT    = 10;
    public const RETURN_TRANSFER = true;
    public const FOLLOW_LOCATION = true;
    public const USE_BENCHMARK   = false;

    /**
     * Hàm lấy phiên bản hiện tại của Package
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:05
     *
     * @return string Phiên bản hiện tại của Package, VD: 3.0.2
     */
    public function getVersion(): string;
}
