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
use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\MyNuSOAP\nusoap_client;
use nguyenanhung\MyRequests\Interfaces\ProjectInterface;

/**
 * Class SoapRequest
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class SoapRequest implements ProjectInterface, SoapRequestInterface
{
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
    private $debug;
    /** @var bool Debug Status */
    public $debugStatus = FALSE;
    /** @var null|string Set level Debug: DEBUG, INFO, ERROR .... */
    public $debugLevel = NULL;
    /** @var null|string Set Logger Path to Save */
    public $debugLoggerPath = NULL;
    /** @var string|null Set Logger Filename to Save */
    public $debugLoggerFilename;

    /**
     * SoapRequest constructor.
     */
    public function __construct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark = new Benchmark();
            $this->benchmark->mark('code_start');
        }
        $this->debug = new Debug();
        if (empty($this->debugLoggerPath)) {
            $this->debugStatus = FALSE;
        }
        $this->debug->setDebugStatus($this->debugStatus);
        $this->debug->setGlobalLoggerLevel($this->debugLevel);
        $this->debug->setLoggerPath($this->debugLoggerPath);
        $this->debug->setLoggerSubPath(__CLASS__);
        if (empty($this->debugLoggerFilename)) {
            $this->debugLoggerFilename = 'Log-' . date('Y-m-d') . '.log';
        }
        $this->debug->setLoggerFilename($this->debugLoggerFilename);
    }

    /**
     * SoapRequest destructor.
     */
    public function __destruct()
    {
        if (self::USE_BENCHMARK === TRUE) {
            $this->benchmark->mark('code_end');
            $this->debug->debug(__FUNCTION__, 'Elapsed Time: ===> ' . $this->benchmark->elapsed_time('code_start', 'code_end'));
            $this->debug->debug(__FUNCTION__, 'Memory Usage: ===> ' . $this->benchmark->memory_usage());
        }
    }

    /**
     * Function getVersion
     *
     * @return mixed|string Current Project Version
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/7/18 02:24
     *
     * @example string 0.1.3
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function setEndpoint
     *
     * @param string $endpoint Link to Url Endpoint
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:26
     *
     */
    public function setEndpoint($endpoint = '')
    {
        $this->endpoint = $endpoint;
        $this->debug->info(__FUNCTION__, 'setEndpoint: ', $this->endpoint);

        return $this;
    }

    /**
     * Function setData
     *
     * @param array $data Data to SOAP Request, call
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:26
     *
     */
    public function setData($data = [])
    {
        $this->data = $data;
        $this->debug->info(__FUNCTION__, 'setData: ', $this->data);

        return $this;
    }

    /**
     * Function setCallFunction
     *
     * @param string $callFunction Require Set Function to call SOAP endpoint
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:36
     *
     */
    public function setCallFunction($callFunction = '')
    {
        $this->callFunction = $callFunction;
        $this->debug->info(__FUNCTION__, 'setCallFunction: ', $this->callFunction);

        return $this;
    }

    /**
     * Function setFieldResult
     * Nếu input giá trì vào đây, result sẽ map trực tiếp đến mã này
     * nếu không có sẽ trả error luôn
     *
     * @param string $fieldResult If input fieldResult, result return $response[$fieldResult] f
     *                            from Response SOAP Service
     *                            Return Error Code if not find $fieldResult from Response
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:37
     *
     */
    public function setFieldResult($fieldResult = '')
    {
        $this->fieldResult = $fieldResult;
        $this->debug->info(__FUNCTION__, 'setFieldResult: ', $this->fieldResult);

        return $this;
    }

    /**
     * Function setResponseIsJson
     * Return Response is Json if value = true
     *
     * @param string $responseIsJson
     *
     * @return $this|mixed if set value = TRUE, response is Json string
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 19:00
     *
     * @see   clientRequestWsdl() method
     */
    public function setResponseIsJson($responseIsJson = '')
    {
        $this->responseIsJson = $responseIsJson;
        $this->debug->info(__FUNCTION__, 'setResponseIsJson: ', $this->responseIsJson);

        return $this;
    }

    /**
     * Function clientRequestWsdl
     *
     * @return array|null|string Call to SOAP request and received Response from Server
     *                           Return is Json String if set setResponseIsJson(true)
     *                           Return Null if class nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not
     *                           exists
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     */
    public function clientRequestWsdl()
    {
        $this->debug->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        if (!class_exists('nguyenanhung\MyNuSOAP\nusoap_client')) {
            $this->debug->critical(__FUNCTION__, 'nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not exists');

            return NULL;
        }
        try {
            $client                   = new nusoap_client($this->endpoint, TRUE);
            $client->soap_defencoding = self::SOAP_ENCODING;
            $client->xml_encoding     = self::XML_ENCODING;
            $client->decode_utf8      = self::DECODE_UTF8;
            $error                    = $client->getError();
            if ($error) {
                $message = "Client Request WSDL Error: " . json_encode($error);
                $this->debug->error(__FUNCTION__, $message);
            } else {
                $result = $client->call($this->callFunction, $this->data);
                $this->debug->info(__FUNCTION__, 'Result from Endpoint: ', $result);
                if ($this->fieldResult) {
                    if (isset($result[$this->fieldResult])) {
                        $this->debug->info(__FUNCTION__, 'Output Result: ', $result[$this->fieldResult]);
                        $message = [
                            'status' => 0,
                            'code'   => $result[$this->fieldResult],
                            'data'   => $result
                        ];
                    } else {
                        $this->debug->info(__FUNCTION__, 'Missing Result from ' . $this->fieldResult);
                        $message = [
                            'status' => 1,
                            'code'   => 'Missing Result from ' . $this->fieldResult,
                            'data'   => $result
                        ];
                    }
                } else {
                    $message = [
                        'status' => 0,
                        'code'   => 'Return full Response',
                        'data'   => $result
                    ];
                }
            }
        }
        catch (Exception $e) {
            $message       = [
                'status' => 2,
                'code'   => 'Exception Error',
                'data'   => [
                    'File'    => $e->getFile(),
                    'Line'    => $e->getLine(),
                    'Code'    => $e->getCode(),
                    'Message' => $e->getMessage(),
                ]
            ];
            $error_message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            if (function_exists('log_message')) {
                log_message('error', $error_message);
            }
            $this->debug->error(__FUNCTION__, $error_message);
        }
        if ($this->responseIsJson) {
            $this->debug->debug(__FUNCTION__, 'Response is Json');
            $message = json_encode($message);
        }
        $this->debug->info(__FUNCTION__, 'Final Result: ', $message);

        return $message;
    }

    /**
     * Function clientRequestSOAP
     *
     * @return array|null|string Call to SOAP request and received Response from Server
     *                           Return is Json String if set setResponseIsJson(true)
     *                           Return Null if class nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not
     *                           exists
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/10/18 11:15
     *
     */
    public function clientRequestSOAP()
    {
        $this->debug->debug(__FUNCTION__, '/------------> ' . __FUNCTION__ . ' <------------\\');
        if (!class_exists('nguyenanhung\MyNuSOAP\nusoap_client')) {
            $this->debug->critical(__FUNCTION__, 'nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not exists');

            return NULL;
        }
        try {
            $client                   = new nusoap_client($this->endpoint, TRUE);
            $client->soap_defencoding = self::SOAP_ENCODING;
            $client->xml_encoding     = self::XML_ENCODING;
            $client->decode_utf8      = self::DECODE_UTF8;
            $error                    = $client->getError();
            if ($error) {
                $message = "Client Request SOAP Error: " . json_encode($error);
                $this->debug->error(__FUNCTION__, $message);
            } else {
                $result = $client->call($this->callFunction, $this->data);
                $this->debug->info(__FUNCTION__, 'Result from Endpoint: ', $result);
                if ($this->fieldResult) {
                    if (isset($result[$this->fieldResult])) {
                        $this->debug->info(__FUNCTION__, 'Output Result: ', $result[$this->fieldResult]);
                        $message = [
                            'status' => 0,
                            'code'   => $result[$this->fieldResult],
                            'data'   => $result
                        ];
                    } else {
                        $this->debug->info(__FUNCTION__, 'Missing Result from ' . $this->fieldResult);
                        $message = [
                            'status' => 1,
                            'code'   => 'Missing Result from ' . $this->fieldResult,
                            'data'   => $result
                        ];
                    }
                } else {
                    $message = [
                        'status' => 0,
                        'code'   => 'Return full Response',
                        'data'   => $result
                    ];
                }
            }
        }
        catch (Exception $e) {
            $message       = [
                'status' => 2,
                'code'   => 'Exception Error',
                'data'   => [
                    'File'    => $e->getFile(),
                    'Line'    => $e->getLine(),
                    'Code'    => $e->getCode(),
                    'Message' => $e->getMessage(),
                ]
            ];
            $error_message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            if (function_exists('log_message')) {
                log_message('error', $error_message);
            }
            $this->debug->error(__FUNCTION__, $error_message);
        }
        if ($this->responseIsJson) {
            $this->debug->debug(__FUNCTION__, 'Response is Json');
            $message = json_encode($message);
        }
        $this->debug->info(__FUNCTION__, 'Final Result: ', $message);

        return $message;
    }
}
