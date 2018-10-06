<?php
/**
 * Project td-vas-report
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/28/18
 * Time: 14:47
 */

namespace nguyenanhung\MyRequests\Repository;
if (!interface_exists('nguyenanhung\MyRequests\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}

use nguyenanhung\MyRequests\Interfaces\ProjectInterface;

class DataRepository implements ProjectInterface
{
    const CONFIG_PATH = 'config';
    const CONFIG_EXT  = '.php';

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:07
     *
     * @return mixed|string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function getData
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/7/18 01:07
     *
     * @param $configName
     *
     * @return array|mixed
     */
    public static function getData($configName)
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . self::CONFIG_PATH . DIRECTORY_SEPARATOR . $configName . self::CONFIG_EXT;
        if (is_file($path) && file_exists($path)) {
            return require($path);
        }

        return [];
    }
}
