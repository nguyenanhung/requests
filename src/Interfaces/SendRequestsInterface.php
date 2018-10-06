<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 03:45
 */

namespace nguyenanhung\MyRequests\Interfaces;


interface SendRequestsInterface
{
    const ENCODING = "utf-8";
    const MAX_REDIRECT = 10;
    public function setHeader($headers = []);
    public function setCookie($cookies = []);
    public function setOptions($options = []);
    public function setTimeout($timeout = 60);
    public function setUserAgent($userAgent = '');
    public function setReferrer($referrer = '');
    public function setRequestIsXml($isXml = FALSE);
    public function setRequestIsJson($isJson = FALSE);
    public function setBasicAuthentication($username = '', $password = '');
    public function pyRequest($url = '', $data = [], $method = 'GET');
}
