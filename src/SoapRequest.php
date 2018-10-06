<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 02:23
 */

namespace nguyenanhung\MyRequests;
if (!interface_exists('nguyenanhung\MyRequests\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}
if (!interface_exists('nguyenanhung\MyRequests\Interfaces\SoapRequestInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'SoapRequestInterface.php';
}

use nguyenanhung\MyRequests\Interfaces\ProjectInterface;
use nguyenanhung\MyRequests\Interfaces\SoapRequestInterface;
use nguyenanhung\MyNuSOAP\nusoap_client;

class SoapRequest implements ProjectInterface, SoapRequestInterface
{
    private $endpoint;
    private $data;
    private $callFunction;
    private $fieldResult;

    /**
     * SoapRequest constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:24
     *
     * @return mixed|string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function setEndpoint
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:26
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint = '')
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Function setData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:26
     *
     * @param array $data
     */
    public function setData($data = [])
    {
        $this->data = $data;
    }

    /**
     * Function setCallFunction
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:36
     *
     * @param string $callFunction
     */
    public function setCallFunction($callFunction = '')
    {
        $this->callFunction = $callFunction;
    }

    /**
     * Function setFieldResult
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:37
     *
     * @param string $fieldResult
     */
    public function setFieldResult($fieldResult = '')
    {
        $this->fieldResult = $fieldResult;
    }

    /**
     * Function clientRequestWsdl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     * @return array|null|string
     */
    public function clientRequestWsdl()
    {
        if (!class_exists('nusoap_client')) {
            return NULL;
        }
        $client                   = new nusoap_client($this->endpoint, TRUE);
        $client->soap_defencoding = self::SOAP_ENCODING;
        $client->xml_encoding     = self::XML_ENCODING;
        $client->decode_utf8      = self::DECODE_UTF8;
        //
        $error = $client->getError();
        if ($error) {
            $message = "Request SOAP Charge Error: " . json_encode($error);
        } else {
            $result = $client->call($this->callFunction, $this->data);
            if (isset($result[$this->fieldResult])) {
                $message = [
                    'status' => 0,
                    'code'   => $result[$this->fieldResult],
                    'data'   => $result
                ];
            } else {
                $message = [
                    'status' => 1,
                    'code'   => 'Missing Result from ' . $this->fieldResult,
                    'data'   => $result
                ];
            }
        }

        return $message;
    }
}
