<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/19/18
 * Time: 13:59
 */

namespace nguyenanhung\MyRequests;

use Exception;
use IPv4\SubnetCalculator;
use IPLib\Factory;
use Curl\Curl;

/**
 * Class Ip
 *
 * @package   nguyenanhung\MyRequests
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Ip implements ProjectInterface
{
    use Version;

    /** @var bool Cấu hình class có nhận IP theo HA Proxy hay không */
    protected $haProxyStatus;

    /**
     * Ip constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
    }

    /**
     * Function getIpAddress
     *
     * @param bool $convertToInteger
     *
     * @return bool|int|string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 43:50
     */
    public function getIpAddress(bool $convertToInteger = FALSE)
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
     * @param bool $haProxyStatus
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 44:11
     */
    public function setHaProxy(bool $haProxyStatus = FALSE): self
    {
        $this->haProxyStatus = $haProxyStatus;

        return $this;
    }

    /**
     * Function getIpByHaProxy
     *
     * @param bool $convertToInteger
     *
     * @return false|int|string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/07/2021 58:38
     */
    public function getIpByHaProxy(bool $convertToInteger = FALSE)
    {
        $key = 'HTTP_X_FORWARDED_FOR';
        if (array_key_exists($key, $_SERVER) === TRUE) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if ($this->ipValidate($ip)) {
                    if ($convertToInteger === TRUE) {
                        return ip2long($ip);
                    }

                    return $ip;
                }
            }
        }

        return FALSE;
    }

    /**
     * Function getRawIpAddress
     *
     * @param bool $convertToInteger
     *
     * @return false|int|string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/07/2021 58:45
     */
    public function getRawIpAddress(bool $convertToInteger = FALSE)
    {
        $ip_keys = array(
            0 => 'HTTP_CF_CONNECTING_IP',
            1 => 'HTTP_X_FORWARDED_FOR',
            2 => 'HTTP_X_FORWARDED',
            3 => 'HTTP_X_IPADDRESS',
            4 => 'HTTP_X_CLUSTER_CLIENT_IP',
            5 => 'HTTP_FORWARDED_FOR',
            6 => 'HTTP_FORWARDED',
            7 => 'HTTP_CLIENT_IP',
            8 => 'HTTP_IP',
            9 => 'REMOTE_ADDR'
        );
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === TRUE) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($this->ipValidate($ip)) {
                        if ($convertToInteger === TRUE) {
                            return ip2long($ip);
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
     * @param string $ip_address
     * @param string $network_range
     *
     * @return bool|string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/20/2021 07:43
     */
    public function ipInRange(string $ip_address = '', string $network_range = '')
    {
        $ip_address    = trim($ip_address);
        $network_range = trim($network_range);
        if (empty($ip_address) || empty($network_range)) {
            return NULL;
        }
        try {
            $address = Factory::parseAddressString($ip_address);
            $range   = Factory::parseRangeString($network_range);

            return $address->matches($range);
        }
        catch (Exception $e) {
            $result = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            if (function_exists('log_message')) {
                log_message('error', 'Error Message: ' . $e->getMessage());
                log_message('error', 'Error Trace As String: ' . $e->getTraceAsString());
            }

            return $result;
        }
    }

    /**
     * Function ipCalculator
     *
     * @param $ip
     * @param $network_size
     *
     * @return array|string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 47:09
     */
    public function ipCalculator($ip, $network_size)
    {
        try {
            $result = new SubnetCalculator($ip, $network_size);

            return $result->getSubnetArrayReport();
        }
        catch (Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            if (function_exists('log_message')) {
                log_message('error', 'Error Message: ' . $e->getMessage());
                log_message('error', 'Error Trace As String: ' . $e->getTraceAsString());
            }

            return $message;
        }
    }

    /**
     * Function ipValidate
     *
     * @param $ip
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 47:25
     */
    public function ipValidate($ip): bool
    {
        return !(filter_var($ip, FILTER_VALIDATE_IP) === false);
    }

    /**
     * Function ipValidateV4
     *
     * @param $ip
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 47:31
     */
    public function ipValidateV4($ip): bool
    {
        return !(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false);
    }

    /**
     * Function ipValidateV6
     *
     * @param $ip
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 47:40
     */
    public function ipValidateV6($ip): bool
    {
        return !(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false);
    }

    /**
     * Function ip2longV6
     *
     * @param $ip
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 47:45
     */
    public function ip2longV6($ip): string
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
     * @param string $ip
     *
     * @return string|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/20/2021 09:30
     */
    public function ipInfo(string $ip = '')
    {
        if (empty($ip)) {
            $ip = $this->getIpAddress();
        }
        try {
            $curl = new Curl();
            $curl->get('http://ip-api.com/json/' . $ip);

            return $curl->error ? "cURL Error: " . $curl->errorMessage : $curl->response;
        }
        catch (Exception $e) {
            if (function_exists('log_message')) {
                log_message('error', 'Error Message: ' . $e->getMessage());
                log_message('error', 'Error Trace As String: ' . $e->getTraceAsString());
            }

            return 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();

        }
    }
}
