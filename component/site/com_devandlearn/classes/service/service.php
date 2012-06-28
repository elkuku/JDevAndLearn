<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/21/12
 * Time: 6:55 AM
 * To change this template use File | Settings | File Templates.
 */

class DalService
{
    protected $name = '';

    protected $url = '';

    protected $links = array();

    protected $isUp = false;

    public function __construct($name, $url, array $links = array())
    {
        $this->name = $name;

        $this->url = $url;

        $this->links = $links;

        $this->check();
    }

    public function __get($key)
    {
        if(in_array($key, array('name', 'url', 'links', 'isUp')))
            return $this->$key;

        return (DAL_DEBUG) ? 'Undefined property: '.$key : '';
    }

    protected function check()
    {
        preg_match('#([a-z]+)://([a-z\s]+)#', $this->url, $matches);

        $protocol = (isset($matches[1])) ? $matches[1] : 'http';

        switch($protocol)
        {
            case 'service' :
                if(isset($matches[2]))
                {
                    switch($matches[2])
                    {
                        case 'proftpd' :
                            exec('ps cax | grep -c "proftpd"', $output);

                            $this->isUp = (isset($output[0]) && (int)$output[0] == 1);
                            break;

                        case 'mysql' :
                            exec('ps cax | grep "mysqld$"', $output, $retcode);

                            $this->isUp = (0 == $retcode);
                            break;

                        case 'pgsql' :
                            exec('ps cax | grep "pgsqld$"', $output, $retcode);

                            $this->isUp = (0 == $retcode);
                            break;

                        default :
                            JFactory::getApplication()->enqueueMessage(sprintf(
                                '%s - Unknown command: %s'
                                , __METHOD__, $matches[2])
                                , 'warning');
                    }
                }

                break;
            case 'http':
                $ch = curl_init($this->url);

                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_exec($ch);

                $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                $this->isUp = (200 == $retcode);
                break;
        }
    }
}
