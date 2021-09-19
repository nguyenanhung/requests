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


// Test Get IP
testOutputWriteLnOnRequest('GET IP Address', getIpAddress());

// Test Simple Request

$url = 'https://httpbin.org';
testOutputWriteLnOnRequest(
    'Test GET Request',
    sendSimpleRequest(
        $url . '/get',
        testCreateParamsOnRequest()
    )
);
