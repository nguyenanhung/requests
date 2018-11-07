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

use nguyenanhung\MyDebug\Debug;

// Test Content
$logPath     = testLogPath();
$logSubPath  = 'tests-debug';
$logFilename = 'Log-' . date('Y-m-d') . '.log';
$name        = 'Test';
$msg         = 'Test Log';
$context     = [
    'name'  => 'Nguyen An Hung',
    'email' => 'dev@nguyenanhung.com'
];
// Call
$Debug = new Debug();
$Debug->setDebugStatus(TRUE);
$Debug->setLoggerPath($logPath);
$Debug->setLoggerSubPath($logSubPath);
$Debug->setLoggerFilename($logFilename);

echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
echo "\n getVersion: " . $Debug->getVersion() . "\n";
echo "\n setDebugStatus: " . $Debug->getDebugStatus() . "\n";
echo "\n setLoggerPath: " . $Debug->getLoggerPath() . "\n";
echo "\n setLoggerSubPath: " . $Debug->getLoggerSubPath() . "\n";
echo "\n setLoggerFilename: " . $Debug->getLoggerFilename() . "\n";
echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";

d($Debug->debug($name, $msg . ' - DEBUG', $context));
d($Debug->info($name, $msg . ' - INFO', $context));
d($Debug->notice($name, $msg . ' - NOTICE', $context));
d($Debug->warning($name, $msg . ' - WARNING', $context));
d($Debug->error($name, $msg . ' - ERROR', $context));
d($Debug->critical($name, $msg . ' - CRITICAL', $context));
d($Debug->alert($name, $msg . ' - ALERT', $context));
d($Debug->emergency($name, $msg . ' - EMERGENCY', $context));

