<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 03:45
 */

namespace nguyenanhung\MyRequests\Interfaces;


interface SendRequestsInterface
{

    public function setHeaders($headers = []);

    public function setOptions($options = []);

    public function setTimeout($timeout = 60);
}