<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'; // Current Package test, remove if init other package
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classmap.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * Project vn-telco-detect.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/18/18
 * Time: 17:30
 */

use nguyenanhung\MyRequests\Helpers\Debug;

// Test Content
$logPath     = __DIR__ . DIRECTORY_SEPARATOR . '../logs/';
$logSubPath  = 'tests-debug';
$logFilename = 'Log-' . date('Y-m-d') . '.log';
$name        = 'Test';
$msg         = 'Test Log';
$context     = [
    'name'  => 'Nguyen An Hung',
    'email' => 'dev@nguyenanhung.com'
];
// Call
$debug = new Debug();
$debug->setDebugStatus(TRUE);
$debug->setLoggerPath($logPath);
$debug->setLoggerSubPath($logSubPath);
$debug->setLoggerFilename($logFilename);

echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
echo "\n getVersion: " . $debug->getVersion() . "\n";
echo "\n setDebugStatus: " . $debug->getDebugStatus() . "\n";
echo "\n setLoggerPath: " . $debug->getLoggerPath() . "\n";
echo "\n setLoggerSubPath: " . $debug->getLoggerSubPath() . "\n";
echo "\n setLoggerFilename: " . $debug->getLoggerFilename() . "\n";
echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";

var_dump($debug->debug($name, $msg . ' - DEBUG', $context));
var_dump($debug->info($name, $msg . ' - INFO', $context));
var_dump($debug->notice($name, $msg . ' - NOTICE', $context));
var_dump($debug->warning($name, $msg . ' - WARNING', $context));
var_dump($debug->error($name, $msg . ' - ERROR', $context));
var_dump($debug->critical($name, $msg . ' - CRITICAL', $context));
var_dump($debug->alert($name, $msg . ' - ALERT', $context));
var_dump($debug->emergency($name, $msg . ' - EMERGENCY', $context));

