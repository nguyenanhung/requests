<?php
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classmap.php';
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * Project td-vas-sctv.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:54
 */

use nguyenanhung\MyRequests\MyRequests;

$debug                    = [
    'debugStatus'     => FALSE,
    'debugLoggerPath' => testLogPath()
];
$url                      = 'https://httpbin.org/get';
$data                     = [
    'date'    => date('Y-m-d'),
    'service' => 'ME',
    'token'   => 'empty'
];
$method                   = 'GET';
$headers                  = [];
$options                  = [];
$MyRequests                  = new MyRequests();
$MyRequests->debugStatus     = FALSE;
$MyRequests->debugLoggerPath = testLogPath();
$MyRequests->__construct();
$MyRequests->setHeader($headers);
$MyRequests->setOptions($options);

$curlRequest = $MyRequests->curlRequest($url, $data, $method);

echo "<pre>";
print_r($curlRequest);
echo "</pre>";

