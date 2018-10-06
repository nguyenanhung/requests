<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/30/18
 * Time: 17:10
 */

namespace nguyenanhung\MyRequests\Helpers\Interfaces;


interface UtilsInterface
{
    /**
     * Function slugify
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 03:16
     *
     * @param string $str
     *
     * @return mixed
     */
    public static function slugify($str = '');
}
