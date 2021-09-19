<?php
/**
 * Project requests
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/20/2021
 * Time: 02:47
 */
if (!function_exists('testOutputWriteLnOnRequest')) {
    /**
     * Function testOutputWriteLnOnRequest
     *
     * @param mixed $name
     * @param mixed $msg
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/20/2021 30:31
     */
    function testOutputWriteLnOnRequest($name = '', $msg = '')
    {
        if (is_array($msg) || is_object($msg)) {
            $msg = json_encode($msg);
        }
        echo $name . ' -> ' . $msg . PHP_EOL;
    }
}
if (!function_exists('testCreateParamsOnRequest')) {
    /**
     * Function testCreateParamsOnRequest
     *
     * @param string $method
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/20/2021 52:27
     */
    function testCreateParamsOnRequest(string $method = 'GET')
    {
        return array(
            'sdk'    => 'HungNG Request',
            'method' => $method,
            'date'   => date('Y-m-d H:i:s')
        );
    }
}