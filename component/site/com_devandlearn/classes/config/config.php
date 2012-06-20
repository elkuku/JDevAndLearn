<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 4:14 AM
 * To change this template use File | Settings | File Templates.
 */

class DalConfig
{
    /**
     * @var SimpleXMLElement
     */
    private static $config = null;

    public static function getConfig()
    {
        if(null == self::$config)
            self::readConfig();

        return self::$config;
    }

    private static function readConfig()
    {
        $path = JComponentHelper::getParams('com_devandlearn')
            ->get('configPath').'/config.xml';

        $path = realpath($path);

        if(false == file_exists($path))
            throw new DomainException('ERROR: Config file not found at:'.$path);

        $xml = simplexml_load_file($path);

        if(false == $xml)
            throw new DomainException('ERROR: Invalid config at:'.$path);

        self::$config = $xml;
    }
}
