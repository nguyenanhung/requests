<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/19/18
 * Time: 13:59
 */

namespace nguyenanhung\MyRequests;

use IPv4\SubnetCalculator;
use nguyenanhung\MyRequests\Interfaces\ProjectInterface;

/**
 * Class Ip
 *
 * @package   nguyenanhung\MyRequests
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Ip implements ProjectInterface
{
    protected $haProxyStatus;

    /**
     * Ip constructor.
     */
    public function __construct()
    {

    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/19/18 14:02
     *
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function getIpAddress
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/13/18 14:16
     *
     * @param bool $convertToInteger
     *
     * @return bool|int|mixed|string
     */
    public function getIpAddress($convertToInteger = FALSE)
    {
        if ($this->haProxyStatus === TRUE) {
            $ip = $this->getIpByHaProxy($convertToInteger);
        } else {
            $ip = $this->getRawIpAddress($convertToInteger);
        }

        return $ip;
    }

    /**
     * Function setHaProxy
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:19
     *
     * @param bool $haProxyStatus
     */
    public function setHaProxy($haProxyStatus = FALSE)
    {
        $this->haProxyStatus = $haProxyStatus;
    }

    /**
     * Function getIpByHaProxy
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:20
     *
     * @param bool $convertToInteger
     *
     * @return bool|int|string
     */
    public function getIpByHaProxy($convertToInteger = FALSE)
    {
        $ip_keys = [
            'HTTP_X_FORWARDED_FOR'
        ];
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === TRUE) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($this->ipValidate($ip)) {
                        if ($convertToInteger === TRUE) {
                            $result = ip2long($ip);

                            return $result;
                        }

                        return $ip;
                    }
                }
            }
        }

        return FALSE;
    }

    /**
     * Function getRawIpAddress
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/12/18 01:12
     *
     * @param bool $convertToInteger
     *
     * @return bool|int|string
     */
    public function getRawIpAddress($convertToInteger = FALSE)
    {
        $ip_keys = Repository\DataRepository::getData('ip_address_server');
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === TRUE) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($this->ipValidate($ip)) {
                        if ($convertToInteger === TRUE) {
                            $result = ip2long($ip);

                            return $result;
                        }

                        return $ip;
                    }
                }
            }
        }

        return FALSE;
    }

    /**
     * Function ipInRange
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:22
     *
     * @param string $ip_address
     * @param string $network_range
     *
     * @return bool|null|string
     */
    public function ipInRange($ip_address = '', $network_range = '')
    {
        $ip_address    = trim($ip_address);
        $network_range = trim($network_range);
        if (empty($ip_address) || empty($network_range)) {
            return NULL;
        }
        try {
            $address = \IPLib\Factory::addressFromString($ip_address);
            $range   = \IPLib\Factory::rangeFromString($network_range);
            $result  = $address->matches($range);

            return $result;
        }
        catch (\Exception $e) {
            return 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
        }
    }

    /**
     * Function ipCalculator
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/12/18 01:18
     *
     * @param $ip
     * @param $network_size
     *
     * @return array|string
     */
    public function ipCalculator($ip, $network_size)
    {
        try {
            $result = new SubnetCalculator($ip, $network_size);

            return $result->getSubnetArrayReport();
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();

            return $message;
        }
    }

    /**
     * Function ipValidate
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/12/18 01:12
     *
     * @param $ip
     *
     * @return bool
     */
    public function ipValidate($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Function ipValidateV4
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/13/18 14:17
     *
     * @param $ip
     *
     * @return bool
     */
    public function ipValidateV4($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === FALSE) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Function ipValidateV6
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/13/18 14:17
     *
     * @param $ip
     *
     * @return bool
     */
    public function ipValidateV6($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === FALSE) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Function ip2longV6
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/20/18 14:26
     *
     * @param $ip
     *
     * @return string
     */
    public function ip2longV6($ip)
    {
        if (substr_count($ip, '::')) {
            $ip = str_replace('::', str_repeat(':0000', 8 - substr_count($ip, ':')) . ':', $ip);
        }
        $ip   = explode(':', $ip);
        $r_ip = '';
        foreach ($ip as $v) {
            $r_ip .= str_pad(base_convert($v, 16, 2), 16, 0, STR_PAD_LEFT);
        }

        return base_convert($r_ip, 2, 10);
    }

    /**
     * Function ipInfo
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:39
     *
     * @param string $ip
     *
     * @return string
     */
    public function ipInfo($ip = '')
    {
        if (empty($ip)) {
            $ip = $this->getIpAddress();
        }
        try {
            $curl = new \Curl\Curl();
            $curl->get('http://ip-api.com/json/' . $ip);
            $response = $curl->error ? "cURL Error: " . $curl->error_message : $curl->response;

            return $response;
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();

            return $message;
        }
    }
}
