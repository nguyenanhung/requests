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

use nguyenanhung\MyDebug\Debug;
use nguyenanhung\MyDebug\Benchmark;
use nguyenanhung\MyNuSOAP\nusoap_client;
use nguyenanhung\MyRequests\Interfaces\ProjectInterface;
use nguyenanhung\MyRequests\Interfaces\SoapRequestInterface;

/**
 * Class SoapRequest
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class SoapRequest implements ProjectInterface, SoapRequestInterface
{
    /**
     * @var string Url Endpoint to Request
     */
    private $endpoint;
    /**
     * @var array Data to Request
     */
    private $data;
    /**
     * @var string Function to Request SOAP Service
     */
    private $callFunction;
    /**
     * @var string Field Result to mapping Response request
     */
    private $fieldResult;
    /**
     * @var bool Set Json Encode Response to Output
     */
    private $responseIsJson;
    /**
     * @var object \nguyenanhung\MyDebug\Benchmark
     */
    private $benchmark;
    /**
     * @var  object \nguyenanhung\MyDebug\Debug Call to class
     */
    private $debug;
    /**
     * Set Debug Status
     *
     * @var bool
     */
    public $debugStatus = FALSE;

    /**
     * @var null Set level Debug: DEBUG, INFO, ERROR ....
     */
    public $debugLevel = NULL;
    /**
     * Set Logger Path to Save
     *
     * @var null|string
     */
    public $debugLoggerPath = NULL;

    /**
     * Set Logger Filename to Save
     *
     * @var string
     */
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
        $this->debug->debug(__FUNCTION__, '/-------------------------> Begin Logger - SOAP Requests - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
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
        $this->debug->debug(__FUNCTION__, '/-------------------------> End Logger - SOAP Requests - Version: ' . self::VERSION . ' - Last Modified: ' . self::LAST_MODIFIED . ' <-------------------------\\');
    }

    /**
     * Function getVersion
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/7/18 02:24
     *
     * @return mixed|string Current Project Version
     * @example string 0.1.3
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
     * @param string $endpoint Link to Url Endpoint
     */
    public function setEndpoint($endpoint = '')
    {
        $this->endpoint = $endpoint;
        $this->debug->info(__FUNCTION__, 'setEndpoint: ', $this->endpoint);
    }

    /**
     * Function setData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:26
     *
     * @param array $data Data to SOAP Request, call
     */
    public function setData($data = [])
    {
        $this->data = $data;
        $this->debug->info(__FUNCTION__, 'setData: ', $this->data);
    }

    /**
     * Function setCallFunction
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:36
     *
     * @param string $callFunction Require Set Function to call SOAP endpoint
     */
    public function setCallFunction($callFunction = '')
    {
        $this->callFunction = $callFunction;
        $this->debug->info(__FUNCTION__, 'setCallFunction: ', $this->callFunction);
    }

    /**
     * Function setFieldResult
     * Nếu input giá trì vào đây, result sẽ map trực tiếp đến mã này
     * nếu không có sẽ trả error luôn
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:37
     *
     * @param string $fieldResult If input fieldResult, result return $response[$fieldResult] f
     *                            from Response SOAP Service
     *                            Return Error Code if not find $fieldResult from Response
     */
    public function setFieldResult($fieldResult = '')
    {
        $this->fieldResult = $fieldResult;
        $this->debug->info(__FUNCTION__, 'setFieldResult: ', $this->fieldResult);
    }

    /**
     * Function setResponseIsJson
     * Return Response is Json if value = true
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 19:00
     *
     * @param string $responseIsJson
     *
     * @return mixed|void if set value = TRUE, response is Json string
     * @see   clientRequestWsdl() method
     */
    public function setResponseIsJson($responseIsJson = '')
    {
        $this->responseIsJson = $responseIsJson;
        $this->debug->info(__FUNCTION__, 'setResponseIsJson: ', $this->responseIsJson);
    }

    /**
     * Function clientRequestWsdl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     * @return array|null|string Call to SOAP request and received Response from Server
     *                           Return is Json String if set setResponseIsJson(true)
     *                           Return Null if class nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not
     *                           exists
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
                $message = "Request SOAP Charge Error: " . json_encode($error);
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
        catch (\Exception $e) {
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
