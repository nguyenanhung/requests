<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 01:45
 */

namespace nguyenanhung\MyRequests\Interfaces;

interface GetContentsInterface
{
    public function getContent();

    public function getError();

    public function response();

    public function sendRequest();

    public function useFileGetContents();

    public function getHeaderArray();

    public function getPostBody();

    public function getQueryString();

    public function setURL($url = '');

    public function setMethod($method = '');

    public function setData($data = []);

    public function setQueryString($query_string = []);

    public function setHeaders($headers = []);

    public function setCookies($cookies = []);

    public function setTrackCookies($value = FALSE);

    public function setXML($value = FALSE);

    public function setJson($value = FALSE);

    public function setJsonPretty($value = FALSE);

    public function setVerifyPeer($value = FALSE);

    public function setWebTimeout($webTimeout = 20);

    public function parseReturnHeaders($headers);
}
