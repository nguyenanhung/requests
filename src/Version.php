<?php
/**
 * Project requests
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/19
 * Time: 10:05
 */

namespace nguyenanhung\MyRequests;

/**
 * Trait Version
 *
 * @package   nguyenanhung\MyRequests
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
trait Version
{
    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:07
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }
}
