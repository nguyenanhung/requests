<?php
/**
 * Project requests.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/7/18
 * Time: 02:27
 */

namespace nguyenanhung\MyRequests\Interfaces;


interface SoapRequestInterface
{
    const SOAP_ENCODING = 'utf-8';
    const XML_ENCODING  = 'utf-8';
    const DECODE_UTF8   = FALSE;

    /**
     * Function setEndpoint
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     * @param string $endpoint
     *
     * @return mixed
     */
    public function setEndpoint($endpoint = '');

    /**
     * Function setData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     * @param array $data
     *
     * @return mixed
     */
    public function setData($data = []);

    /**
     * Function setCallFunction
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     * @param string $callFunction
     *
     * @return mixed
     */
    public function setCallFunction($callFunction = '');

    /**
     * Function setFieldResult
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     * @param string $fieldResult
     *
     * @return mixed
     */
    public function setFieldResult($fieldResult = '');

    /**
     * Function setResponseIsJson
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/8/18 19:00
     *
     * @param string $responseIsJson
     *
     * @return mixed
     */
    public function setResponseIsJson($responseIsJson = '');

    /**
     * Function clientRequestWsdl
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 02:41
     *
     * @return mixed
     */
    public function clientRequestWsdl();
}
