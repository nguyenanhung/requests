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

use nguyenanhung\MyRequests\GetContents;

// Test Data
$url    = 'http://vcms.gviet.vn/api/v1/shared-content/vietlott.html';
$data   = [
    'date'    => date('Y-m-d'),
    'service' => 'ME',
    'token'   => 'empty'
];
$method = 'GET';
// Let's Go
$content = new GetContents();
$content->setURL($url);
$content->setMethod($method);
$content->setData($data);
$content->sendRequest();

$response   = $content->response();
$getContent = $content->getContent();
$getError   = $content->getError();

var_dump($response);
var_dump($getContent);
var_dump($getError);

