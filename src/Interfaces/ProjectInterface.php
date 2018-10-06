<?php
/**
 * Project td-vas-report.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:55
 */

namespace nguyenanhung\MyRequests\Interfaces;


interface ProjectInterface
{
    const VERSION = '0.1.0';
    const GET     = 'GET';
    const HEAD    = 'HEAD';
    const DELETE  = 'DELETE';
    const TRACE   = 'TRACE';
    const POST    = 'POST';
    const PUT     = 'PUT';
    const OPTIONS = 'OPTIONS';
    const PATCH   = 'PATCH';

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:05
     *
     * @return mixed
     */
    public function getVersion();
}
