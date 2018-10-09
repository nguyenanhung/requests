# My Requests

Library Interface Requests use cURL, File Get Contents, SOAP Requests

Library use package: Curl, GuzzleHttp, Requests and nuSoap

### Installation

**Manual install**

Step 1: Save library to your project

```shell
cd /your/to/path
wget https://github.com/nguyenanhung/requests/archive/master.zip
unzip master.zip
```

Step 2: Init to Project

```php
<?php 
require '/your/to/path/MyRequests.php';
use \nguyenanhung\MyRequests\MyRequests;

$requests = new MyRequests();

```

**Install with composer**

Step 1: Install package

```shell
composer require nguyenanhung/requests
```

Step 2: Init to Project

```php
<?php 
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\MyRequests\MyRequests;
$requests = new MyRequests();
```

### **How to Use**

**Get Version of Library**

```php
<?php
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\MyRequests\MyRequests;
$requests = new MyRequests();

echo $requests->getVersion(); // Print: 0.1.3.4
```

##### Send Request

```php
<?php
require '/your/to/path/vendor/autoload.php';
use nguyenanhung\MyRequests\MyRequests;

$debug                    = [
    'debugStatus'     => TRUE,
    'debugLoggerPath' => testLogPath()
];
$url                      = 'https://httpbin.org/';
$data                     = [
    'date'    => date('Y-m-d'),
    'service' => 'ME',
    'token'   => 'empty'
];
$method                   = 'GET';
$headers                  = [];
$options                  = [];
$request                  = new MyRequests();
$request->debugStatus     = TRUE;
$request->debugLoggerPath = '/your/to/path/save_log';
$request->__construct();
$request->setHeader($headers);
$request->setOptions($options);

echo $requests->getVersion(); // Print: 0.1.3.4

$pyRequest = $request->pyRequest($url, $data, $method);
d($pyRequest);

$guzzlePhpRequest = $request->guzzlePhpRequest($url, $data, $method);
d($guzzlePhpRequest);

$curlRequest = $request->curlRequest($url, $data, $method);
d($curlRequest);

$sendRequest = $request->sendRequest($url, $data, $method);
d($sendRequest);
```

##### Send Request with File Get Contents

```php
<?php
require '/your/to/path/vendor/autoload.php';
use nguyenanhung\MyRequests\GetContents;

// Test Data
$url    = 'https://httpbin.org/';
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

echo $content->getVersion(); // Print: 0.1.3.4

$response   = $content->response();
$getContent = $content->getContent();
$getError   = $content->getError();

d($response);
d($getContent);
d($getError);
```

##### Send Request with SOAP Request

```php
<?php
require '/your/to/path/vendor/autoload.php';
use nguyenanhung\MyRequests\SoapRequest;

$soap                  = new SoapRequest();
$soap->debugStatus     = true;
$soap->debugLoggerPath = '/your/to/path/save_log';
$soap->__construct();
$soap->setEndpoint('url');
$soap->setCallFunction('function');
$soap->setData($data);
$result = $soap->clientRequestWsdl();

echo $soap->getVersion(); // Print: 0.1.3.4
d($result);
```



### Contact

If any quetion & request, please contact following infomation

| Name        | Email                | Skype            | Facebook      |
| ----------- | -------------------- | ---------------- | ------------- |
| Hung Nguyen | dev@nguyenanhung.com | nguyenanhung5891 | @nguyenanhung |

From Hanoi with Love <3