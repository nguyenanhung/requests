<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/16/18
 * Time: 17:07
 */

namespace nguyenanhung\MyRequests;

/**
 * Class Utils
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class Utils
{
    /**
     * Function httpStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:07
     *
     * @param $num
     *
     * @return array
     */
    public static function httpStatus($num)
    {
        $http = [
            100 => 'HTTP/1.1 100 Continue',
            101 => 'HTTP/1.1 101 Switching Protocols',
            200 => 'HTTP/1.1 200 OK',
            201 => 'HTTP/1.1 201 Created',
            202 => 'HTTP/1.1 202 Accepted',
            203 => 'HTTP/1.1 203 Non-Authoritative Information',
            204 => 'HTTP/1.1 204 No Content',
            205 => 'HTTP/1.1 205 Reset Content',
            206 => 'HTTP/1.1 206 Partial Content',
            300 => 'HTTP/1.1 300 Multiple Choices',
            301 => 'HTTP/1.1 301 Moved Permanently',
            302 => 'HTTP/1.1 302 Found',
            303 => 'HTTP/1.1 303 See Other',
            304 => 'HTTP/1.1 304 Not Modified',
            305 => 'HTTP/1.1 305 Use Proxy',
            307 => 'HTTP/1.1 307 Temporary Redirect',
            400 => 'HTTP/1.1 400 Bad Request',
            401 => 'HTTP/1.1 401 Unauthorized',
            402 => 'HTTP/1.1 402 Payment Required',
            403 => 'HTTP/1.1 403 Forbidden',
            404 => 'HTTP/1.1 404 Not Found',
            405 => 'HTTP/1.1 405 Method Not Allowed',
            406 => 'HTTP/1.1 406 Not Acceptable',
            407 => 'HTTP/1.1 407 Proxy Authentication Required',
            408 => 'HTTP/1.1 408 Request Time-out',
            409 => 'HTTP/1.1 409 Conflict',
            410 => 'HTTP/1.1 410 Gone',
            411 => 'HTTP/1.1 411 Length Required',
            412 => 'HTTP/1.1 412 Precondition Failed',
            413 => 'HTTP/1.1 413 Request Entity Too Large',
            414 => 'HTTP/1.1 414 Request-URI Too Large',
            415 => 'HTTP/1.1 415 Unsupported Media Type',
            416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
            417 => 'HTTP/1.1 417 Expectation Failed',
            500 => 'HTTP/1.1 500 Internal Server Error',
            501 => 'HTTP/1.1 501 Not Implemented',
            502 => 'HTTP/1.1 502 Bad Gateway',
            503 => 'HTTP/1.1 503 Service Unavailable',
            504 => 'HTTP/1.1 504 Gateway Time-out',
            505 => 'HTTP/1.1 505 HTTP Version Not Supported',
        ];
        header($http[$num]);

        return [
            'code'  => $num,
            'error' => $http[$num],
        ];
    }

    /**
     * Function getHost
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:08
     *
     * @return string
     */
    public static function getHost()
    {
        $host = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && $host = $_SERVER['HTTP_X_FORWARDED_HOST']) {
            $elements = explode(',', $host);
            $host     = trim(end($elements));
        } else {
            if (isset($_SERVER['HTTP_HOST']) && !$host = $_SERVER['HTTP_HOST']) {
                if (isset($_SERVER['SERVER_NAME']) && !$host = $_SERVER['SERVER_NAME']) {
                    $host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
                }
            }
        }
        // Remove port number from host
        $host = preg_replace('/:\d+$/', '', $host);

        return trim($host);
    }

    /**
     * Function getBrowserLanguage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:09
     *
     * @return bool|string
     */
    public static function getBrowserLanguage()
    {
        $language = '';
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }

        return $language;
    }

    /**
     * Function paddingWebsitePrefix
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:10
     *
     * @param $url
     *
     * @return string
     */
    public static function paddingWebsitePrefix($url)
    {
        if (strpos($url, 'http') !== 0) {
            $url = 'http://' . $url;
        }

        return $url;
    }

    /**
     * Function urlAddParam
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:12
     *
     * @param $url
     * @param $paramString
     *
     * @return string
     */
    public static function urlAddParam($url, $paramString)
    {
        // neu chua co dau ?
        if (strpos($url, '?') === FALSE) {
            $url .= '?';
        }

        return $url . '&' . $paramString;
    }

    /**
     * Function currentPageURL
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:12
     *
     * @return mixed|string
     */
    public static function currentPageURL()
    {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        $pageURL = str_replace('?live', '?', $pageURL);
        $pageURL = str_replace('&live', '', $pageURL);

        return $pageURL;
    }

    /**
     * Ham replace cac ky tu dash thua (double dash --> single dash, remove first and last dash in url)
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:14
     *
     * @param $url
     *
     * @return bool|null|string|string[]
     */
    public static function refineDashInUrl($url)
    {
        $url = preg_replace('/[-]+/', '-', $url);
        if ($url[0] == '-') {
            $url = substr($url, 1);
        }
        if ($url[strlen($url) - 1] == '-') {
            $url = substr($url, 0, strlen($url) - 1);
        }

        return $url;
    }

    /**
     * Function saveExternalFile
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:13
     *
     * @param string $img      : URL of external file
     * @param string $fullpath : local filepath
     * @param string $type     : type of external file.
     * @param bool   $isUseCurl
     *
     * @return bool|int
     */
    public static function saveExternalFile($img, $fullpath, $type = 'image', $isUseCurl = TRUE)
    {
        if ($isUseCurl) {
            //$fullpath = urlencode($fullpath);
            $ch = curl_init($img);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $raw_data = curl_exec($ch);
            curl_close($ch);
            //check if return error (include html in output)
            if (strpos($raw_data, 'html') === FALSE) {
                $fp = fopen($fullpath, 'w');
                if (!$fp) {
                    return FALSE;
                } elseif (!empty($raw_data)) {
                    fwrite($fp, $raw_data);
                    fclose($fp);

                    return TRUE;
                }
            } else {
                return FALSE;
            }
        } else {
            $file_headers = @get_headers($img);
            if (strpos($file_headers[0], '200') || strpos($file_headers[0], '302') || strpos($file_headers[0], '304')) {
                return file_put_contents($fullpath, file_get_contents($img));
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }

    /**
     * Function xssClean
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/16/18 17:14
     *
     * @param $data
     *
     * @return null|string|string[]
     */
    public static function xssClean($data)
    {
        // Fix &entity\n;
        //$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data     = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
    }
}
