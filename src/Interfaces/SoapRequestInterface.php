<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 02:27
 */

namespace nguyenanhung\MyRequests\Interfaces;
/**
 * Interface SoapRequestInterface
 *
 * @package    nguyenanhung\MyRequests\Interfaces
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface SoapRequestInterface
{
    /**
     * Default SOAP Encoding
     */
    const SOAP_ENCODING = 'utf-8';
    /**
     * Default XML Encoding
     */
    const XML_ENCODING = 'utf-8';
    /**
     * Default Decode UTF8 Status
     */
    const DECODE_UTF8 = FALSE;

    /**
     * Function setEndpoint
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:26
     *
     * @param string $endpoint Link to Url Endpoint
     */
    public function setEndpoint($endpoint = '');

    /**
     * Function setData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:26
     *
     * @param array $data Data to SOAP Request, call
     */
    public function setData($data = []);

    /**
     * Function setCallFunction
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:36
     *
     * @param string $callFunction Require Set Function to call SOAP endpoint
     */
    public function setCallFunction($callFunction = '');

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
     */
    public function setFieldResult($fieldResult = '');

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
    public function setResponseIsJson($responseIsJson = '');

    /**
     * Function clientRequestWsdl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     * @return array|null|string Call to SOAP request and received Response from Server
     *                           Return is Json String if set setResponseIsJson(true)
     *                           Return Null if class nguyenanhung\MyNuSOAP\nusoap_client is unavailable, class is not exists
     */
    public function clientRequestWsdl();
}
