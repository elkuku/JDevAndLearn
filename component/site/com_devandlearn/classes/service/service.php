<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/21/12
 * Time: 6:55 AM
 * To change this template use File | Settings | File Templates.
 */

/**
 * @property-read string $cssClass
 * @property-read string $label
 */
class DalService
{
	const DOWN = 0;
	const UP = 1;
	const UNKNOWN = 2;

    protected $name = '';

    protected $url = '';

    protected $links = array();

    protected $isUp = false;

	protected $expected = false;

	protected $cssClass = '';

	protected $label = '';

    public function __construct($name, $url, array $links = array(), $expected = false)
    {
        $this->name = $name;

        $this->url = $url;

        $this->links = $links;

	    $this->expected = $expected;

        $this->check();
    }

    public function __get($key)
    {
        if(in_array($key, array('name', 'url', 'links', 'isUp', 'cssClass', 'label')))
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
	                        exec('/opt/lampp/bin/ftpwho 2>&1', $output, $retVar);

//                            exec('ps cax | grep -c "proftpd"', $output);

  //                          $this->isUp = (isset($output[0]) && (int)$output[0] == 1);
	                        $status = (0 == $retVar) ? self::UP : self::DOWN;
	                        $this->setStatus($status);
	                        break;

	                    case 'apache' :
		                    exec('ps cax | grep "httpd$"', $output, $retVar);

		                    $status = (0 == $retVar) ? self::UP : self::DOWN;
		                    $this->setStatus($status);
		                    break;

	                    case 'mysql' :
                            exec('ps cax | grep "mysqld$"', $output, $retVar);

                            $status = (0 == $retVar) ? self::UP : self::DOWN;
                            $this->setStatus($status);
                            break;

                        case 'pgsql' :
                            exec('rcpostgresql status', $output, $retVar);
                       //     exec('ps cax | grep "pgsqld$"', $output, $retVar);
//var_dump($output, $retVar);
  //                          $this->isUp = (0 == $retVar);
                            switch($retVar)
                            {
	                            case 0 :
		                            $this->setStatus(self::UP);
		                            break;

		                        case 3 :
		                            $this->setStatus(self::DOWN);
		                            break;

		                        default:
		                            $this->setStatus(self::UNKNOWN);
		                            break;
                            }
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

                $expected = $this->expected ?: 200;

                $status = ($expected == $retcode) ? self::UP : self::DOWN;
                $this->setStatus($status);
                break;
        }
    }

	protected function setStatus($status)
	{
		switch($status)
		{
			case self::UP :
				$this->isUp = self::UP;
				$this->cssClass = 'success';
				$this->label = 'Running';//@jgettext
				break;

			case self::DOWN :
				$this->isUp = self::DOWN;
				$this->cssClass = 'info';
				$this->label = 'Down';//@jgettext
				break;

			case self::UNKNOWN :
			default :
				$this->isUp = self::UNKNOWN;
				$this->cssClass = 'inverse';
				$this->label = 'N/A';//@jgettext
				break;
		}
	}
}
