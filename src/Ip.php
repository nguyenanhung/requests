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
    use Version;

    /** @var bool Cấu hình class có nhận IP theo HA Proxy hay không */
    protected $haProxyStatus;

    /**
     * Ip constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function getIpAddress
     *
     * @param bool $convertToInteger
     *
     * @return bool|int|mixed|string
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/13/18 14:16
     *
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
     * @param bool $haProxyStatus
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:19
     *
     */
    public function setHaProxy($haProxyStatus = FALSE)
    {
        $this->haProxyStatus = $haProxyStatus;
    }

    /**
     * Function getIpByHaProxy
     *
     * @param bool $convertToInteger
     *
     * @return bool|int|string
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:20
     *
     */
    public function getIpByHaProxy($convertToInteger = FALSE)
    {
        $ip_keys = ['HTTP_X_FORWARDED_FOR'];
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
     * @param bool $convertToInteger
     *
     * @return bool|int|string
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/12/18 01:12
     *
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
     * @param string $ip_address
     * @param string $network_range
     *
     * @return bool|null|string
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:22
     *
     */
    public function ipInRange($ip_address = '', $network_range = '')
    {
        $ip_address    = trim($ip_address);
        $network_range = trim($network_range);
        if (empty($ip_address) || empty($network_range)) {
            return NULL;
        }
        try {
            $address = Factory::addressFromString($ip_address);
            $range   = Factory::rangeFromString($network_range);
            $result  = $address->matches($range);

            return $result;
        }
        catch (Exception $e) {
            $result = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            if (function_exists('log_message')) {
                log_message('error', $result);
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
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/12/18 01:18
     *
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
                log_message('error', $message);
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
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/12/18 01:12
     *
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
     * @param $ip
     *
     * @return bool
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/13/18 14:17
     *
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
     * @param $ip
     *
     * @return bool
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/13/18 14:17
     *
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
     * @param $ip
     *
     * @return string
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 9/20/18 14:26
     *
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
     * @param string $ip
     *
     * @return string
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/18/18 11:39
     *
     */
    public function ipInfo($ip = '')
    {
        if (empty($ip)) {
            $ip = $this->getIpAddress();
        }
        try {
            $curl = new Curl();
            $curl->get('http://ip-api.com/json/' . $ip);
            $response = $curl->error ? "cURL Error: " . $curl->errorMessage : $curl->response;

            return $response;
        }
        catch (Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            if (function_exists('log_message')) {
                log_message('error', $message);
            }

            return $message;
        }
    }
}
