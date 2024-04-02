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


use nguyenanhung\MyRequests\Utils;

$tmpFolder = dirname(__DIR__) . '/tmp';
$utils = new Utils();

testOutputWriteLnOnRequest('Utils HTTP Status with 200', $utils::httpStatus(200));
testOutputWriteLnOnRequest('Utils getHost', $utils::getHost());
testOutputWriteLnOnRequest('Utils getBrowserLanguage', $utils::getBrowserLanguage());
testOutputWriteLnOnRequest('Utils paddingWebsitePrefix nguyenanhung.com', $utils::paddingWebsitePrefix('nguyenanhung.com'));
testOutputWriteLnOnRequest('Utils refineDashInUrl nguyenanhung.com', $utils::refineDashInUrl('https://nguyenanhung.com///'));
testOutputWriteLnOnRequest('Utils saveExternalFile', $utils::saveExternalFile('https://i3.wp.com/nguyenanhung.com/assets/HungNA.png', $tmpFolder . '/HungNa.png'));
