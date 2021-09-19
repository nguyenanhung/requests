<?php
/**
 * Project requests
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/20/2021
 * Time: 02:28
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/functions.php';


use nguyenanhung\MyRequests\Ip;

$ip = new Ip();

testOutputWriteLnOnRequest('GET IP Address', $ip->getIpAddress());
testOutputWriteLnOnRequest('GET IP Information', $ip->ipInfo('142.250.204.142'));
