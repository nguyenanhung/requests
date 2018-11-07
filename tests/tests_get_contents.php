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
$GetContents = new GetContents();
$GetContents->setURL($url);
$GetContents->setMethod($method);
$GetContents->setData($data);
$GetContents->sendRequest();

$response   = $GetContents->response();
$getContent = $GetContents->getContent();
$getError   = $GetContents->getError();

d($response);
d($getContent);
d($getError);

