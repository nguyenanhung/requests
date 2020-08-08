<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 02:27
 */

namespace nguyenanhung\MyRequests;

/**
 * Interface SoapRequestInterface
 *
 * @package    nguyenanhung\MyRequests
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
interface SoapRequestInterface
{
    const SOAP_ENCODING = 'utf-8'; // Default SOAP Encoding
    const XML_ENCODING  = 'utf-8'; // Default XML Encoding
    const DECODE_UTF8   = FALSE; // Default Decode UTF8 Status

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
    public function setEndpoint($endpoint = '');

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
    public function setData($data = array());

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
    public function setCallFunction($callFunction = '');

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
    public function setFieldResult($fieldResult = '');

    /**
     * Function setResponseIsJson - Return Response is Json if value = true
     *
     * @param string $responseIsJson
     *
     * @return $this|mixed if set value = TRUE, response is Json string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/8/18 19:00
     *
     * @see      clientRequestWsdl() method
     */
    public function setResponseIsJson($responseIsJson = '');

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
    public function clientRequestWsdl();

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
    public function clientRequestSOAP();
}
