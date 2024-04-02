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

use nguyenanhung\MyRequests\MyRequests;

$loggerPath = dirname(__DIR__) . '/tmp';

$request = new MyRequests();
$request->debugStatus = true;
$request->debugLevel = 'info';
$request->debugLoggerPath = dirname(__DIR__) . '/tmp';
$request->debugLoggerFilename = 'Log-' . date('Y-m-d') . '.log';
$request->debugStatus = true;
$request->__construct();

$url = 'https://httpbin.org';

echo dirname(__DIR__) . '/tmp';
// Test Request GET

testOutputWriteLnOnRequest('Test GET Request', $request->sendRequest(
	$url . '/get',
	testCreateParamsOnRequest()
));
