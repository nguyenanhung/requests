<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 02:23
 */

namespace nguyenanhung\MyRequests;

use Exception;
use nguyenanhung\MyDebug\Logger;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\MyNuSOAP\nusoap_client;

/**
 * Class SoapRequest
 *
 * @package   nguyenanhung\MyRequests
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class SoapRequest implements ProjectInterface
{
    use Version;

    const SOAP_ENCODING = 'utf-8'; // Default SOAP Encoding

    const XML_ENCODING = 'utf-8'; // Default XML Encoding

    const DECODE_UTF8 = false; // Default Decode UTF8 Status

    /**@var string Url Endpoint to Request */
    private $endpoint;
    /**@var array Data to Request */
    private $data;
    /**@var string Function to Request SOAP Service */
    private $callFunction;
    /**@var string Field Result to mapping Response request */
    private $fieldResult;
    /**@var bool Set Json Encode Response to Output */
    private $responseIsJson;
    /**@var object \nguyenanhung\MyDebug\Benchmark */
    private $benchmark;
    /**@var object \nguyenanhung\MyDebug\Debug Call to class */
    private $logger;
    /** @var bool Debug Status */
    public $debugStatus = false;
    /** @var null|string Set level Debug: DEBUG, INFO, ERROR .... */
    public $debugLevel = 'error';
    /** @var string Set Logger Path to Save */
    public $debugLoggerPath = '';
    /** @var string|null Set Logger Filename to Save */
    public $debugLoggerFilename = '';

    /**
     * SoapRequest constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        if (self::USE_BENCHMARK === true) {
            $this->benchmark = new Benchmark();
            $this->benchmark->mark('code_start');
        }
        $this->logger = new Logger();
        if (empty($this->debugLoggerPath)) {
            $this->debugStatus = false;
        }
        $this->logger->setDebugStatus($this->debugStatus);
        $this->logger->setGlobalLoggerLevel($this->debugLevel);
        $this->logger->setLoggerPath($this->debugLoggerPath);
        $this->logger->setLoggerSubPath(__CLASS__);
        if (empty($this->debugLoggerFilename)) {
            $this->debugLoggerFilename = 'Log-' . date('Y-m-d') . '.log';
        }
        $this->logger->setLoggerFilename($this->debugLoggerFilename);
    }

    /**
     * SoapRequest destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === true) {
            $this->benchmark->mark('code_end');
            $this->logger->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->logger->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
    }

    /**
     * Function setEndpoint - Cấu hình URL SOAP Endpoint cần gọi
     *
     * @param string $endpoint Link to Url Endpoint
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 32:50
     */
    public function setEndpoint($endpoint = '')
    {
        $this->endpoint = $endpoint;
        $this->logger->debug(__FUNCTION__, 'setEndpoint: ' . $this->endpoint);

        return $this;
    }

    /**
     * Function setData - Cấu hình dữ liệu cần gọi qua SOAP Request
     *
     * @param array $data Data to SOAP Request, call
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 33:22
     */
    public function setData(array $data = array())
    {
        $this->data = $data;
        $this->logger->debug(__FUNCTION__, 'setData: ', $this->data);

        return $this;
    }

    /**
     * Function setCallFunction - Cấu hình hàm SOAP cần gọi trong Endpoint
     *
     * @param string $callFunction Require Set Function to call SOAP endpoint
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 34:00
     */
    public function setCallFunction($callFunction = '')
    {
        $this->callFunction = $callFunction;
        $this->logger->debug(__FUNCTION__, 'setCallFunction: ' . $this->callFunction);

        return $this;
    }

    /**
     * Function setFieldResult - Nếu input giá trì vào đây, result sẽ map trực tiếp đến mã này, nếu không có sẽ trả error luôn
     *
     * @param string $fieldResult If input fieldResult, result return $response[$fieldResult] f
     *                            from Response SOAP Service
     *                            Return Error Code if not find $fieldResult from Response
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 08/08/2020 34:39
     *
     */
    public function setFieldResult($fieldResult = '')
    {
        $this->fieldResult = $fieldResult;
        $this->logger->debug(__FUNCTION__, 'setFieldResult: ' . $this->fieldResult);

        return $this;
    }

    /**
     * Function setResponseIsJson - Return Response is Json if value = true
     *
     * @param bool $responseIsJson
     *
     * @return $this if set value = TRUE, response is Json string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/8/18 19:00
     *
     * @see      clientRequestWsdl() method
     */
    public function setResponseIsJson($responseIsJson = false)
    {
        $this->responseIsJson = $responseIsJson;
        $this->logger->debug(__FUNCTION__, 'setResponseIsJson: ' . $this->responseIsJson);

        return $this;
    }

    /**
     * Function clientRequestWsdl - Hàm khởi tạo reques tới endpoint qua giao thức WSDL
     *
     * @return array|false|string|null Call to SOAP request and received Response from Server
     *                           Return is Json String if set setResponseIsJson(true)
     *                           Return Null if class nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not
     *                           exists
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/7/18 02:41
     */
    public function clientRequestWsdl()
    {
        $this->logger->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        if (!class_exists(nusoap_client::class)) {
            $this->logger->critical(__FUNCTION__, 'nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not exists');

            return null;
        }
        try {
            $client                   = new nusoap_client($this->endpoint, true);
            $client->soap_defencoding = self::SOAP_ENCODING;
            $client->xml_encoding     = self::XML_ENCODING;
            $client->decode_utf8      = self::DECODE_UTF8;
            $error                    = $client->getError();
            if ($error) {
                $message = "Client Request WSDL Error: " . json_encode($error);
                $this->logger->error(__FUNCTION__, $message);
            } else {
                $result = $client->call($this->callFunction, $this->data);
                $this->logger->debug(__FUNCTION__, 'Result from Endpoint: ', $result);
                if ($this->fieldResult) {
                    if (isset($result[$this->fieldResult])) {
                        $this->logger->debug(__FUNCTION__, 'Output Result: ', $result[$this->fieldResult]);
                        $message = array(
                            'status' => 0,
                            'code'   => $result[$this->fieldResult],
                            'data'   => $result
                        );
                    } else {
                        $this->logger->debug(__FUNCTION__, 'Missing Result from ' . $this->fieldResult);
                        $message = array(
                            'status' => 1,
                            'code'   => 'Missing Result from ' . $this->fieldResult,
                            'data'   => $result
                        );
                    }
                } else {
                    $message = array(
                        'status' => 0,
                        'code'   => 'Return full Response',
                        'data'   => $result
                    );
                }
            }
        } catch (Exception $e) {
            $message = array(
                'status' => 2,
                'code'   => 'Exception Error',
                'data'   => array(
                    'File'    => $e->getFile(),
                    'Line'    => $e->getLine(),
                    'Code'    => $e->getCode(),
                    'Message' => $e->getMessage()
                )
            );
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
            $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());
        }
        if ($this->responseIsJson) {
            $this->logger->debug(__FUNCTION__, 'Response is Json');
            $message = json_encode($message);
        }
        $this->logger->debug(__FUNCTION__, 'Final Result: ', $message);

        return $message;
    }

    /**
     * Function clientRequestSOAP - Hàm khởi tạo reques tới endpoint qua giao thức SOAP
     *
     * @return array|null|string Call to SOAP request and received Response from Server
     *                           Return is Json String if set setResponseIsJson(true)
     *                           Return Null if class nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not
     *                           exists
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 11/10/18 11:15
     */
    public function clientRequestSOAP()
    {
        $this->logger->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        if (!class_exists(nusoap_client::class)) {
            $this->logger->critical(__FUNCTION__, 'nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not exists');

            return null;
        }
        try {
            $client                   = new nusoap_client($this->endpoint, true);
            $client->soap_defencoding = self::SOAP_ENCODING;
            $client->xml_encoding     = self::XML_ENCODING;
            $client->decode_utf8      = self::DECODE_UTF8;
            $error                    = $client->getError();
            if ($error) {
                $message = "Client Request SOAP Error: " . json_encode($error);
                $this->logger->error(__FUNCTION__, $message);
            } else {
                $result = $client->call($this->callFunction, $this->data);
                $this->logger->debug(__FUNCTION__, 'Result from Endpoint: ', $result);
                if ($this->fieldResult) {
                    if (isset($result[$this->fieldResult])) {
                        $this->logger->debug(__FUNCTION__, 'Output Result: ', $result[$this->fieldResult]);
                        $message = array(
                            'status' => 0,
                            'code'   => $result[$this->fieldResult],
                            'data'   => $result
                        );
                    } else {
                        $this->logger->debug(__FUNCTION__, 'Missing Result from ' . $this->fieldResult);
                        $message = array(
                            'status' => 1,
                            'code'   => 'Missing Result from ' . $this->fieldResult,
                            'data'   => $result
                        );
                    }
                } else {
                    $message = array(
                        'status' => 0,
                        'code'   => 'Return full Response',
                        'data'   => $result
                    );
                }
            }
        } catch (Exception $e) {
            $message = array(
                'status' => 2,
                'code'   => 'Exception Error',
                'data'   => array(
                    'File'    => $e->getFile(),
                    'Line'    => $e->getLine(),
                    'Code'    => $e->getCode(),
                    'Message' => $e->getMessage()
                )
            );
            $this->logger->error(__FUNCTION__, 'Error Message: ' . $e->getMessage());
            $this->logger->error(__FUNCTION__, 'Error Trace As String: ' . $e->getTraceAsString());
        }
        if ($this->responseIsJson) {
            $this->logger->debug(__FUNCTION__, 'Response is Json');
            $message = json_encode($message);
        }
        $this->logger->debug(__FUNCTION__, 'Final Result: ', $message);

        return $message;
    }
}
