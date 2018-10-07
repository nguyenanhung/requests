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

use nguyenanhung\MyRequests\SendRequests;

$debug                    = [
    'debugStatus'     => TRUE,
    'debugLoggerPath' => testLogPath()
];
$url                      = 'http://vcms.gviet.vn/api/v1/shared-content/vietlott.html';
$data                     = [
    'date'    => date('Y-m-d'),
    'service' => 'ME',
    'token'   => 'empty'
];
$method                   = 'GET';
$headers                  = [];
$options                  = [];
$request                  = new SendRequests();
$request->debugStatus     = TRUE;
$request->debugLoggerPath = testLogPath();
$request->__construct();
$request->setHeader($headers);
$request->setOptions($options);

//$pyRequest = $request->pyRequest($url, $data, $method);
//var_dump($pyRequest);

$curlRequest = $request->curlRequest($url, $data, $method);
var_dump($curlRequest);