<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 7/1/12
 * Time: 7:00 AM
 * To change this template use File | Settings | File Templates.
 */

class JdlProcessorIni
{
    private $ini = array();

    public function __construct($path)
    {
        if(false == file_exists($path))
            throw new DomainException(__METHOD__.' - Ini file not found in path: '.$path);

        $ini = array();
        $key = 'default';

        foreach(file($path) as $line)
        {
            if(0 === strpos($line, '['))
            {
                $key = trim($line);

                $ini[$key] = array();

                continue;
            }

            $parts = explode('=', $line);

            if(2 !== count($parts))
                throw new UnexpectedValueException(__METHOD__.' - Parts count must be 2');

            $ini[$key][$parts[0]] = trim($parts[1]);
        }

        if(0 === count($ini))
            throw new UnexpectedValueException(sprintf('%s - Can not read the ini file at: %s'
                , __METHOD__, $path));

        $this->ini = $ini;
    }

    public function set($key, $value, $group = 'default')
    {
        if(false == array_key_exists($group, $this->ini))
            throw new UnexpectedValueException(sprintf('%s - Invalid group: %s'
                , __METHOD__, $group));

        if(false == array_key_exists($key, $this->ini[$group]))
            throw new UnexpectedValueException(sprintf('%s - Invalid key: %s'
                , __METHOD__, $key));

        $this->ini[$group][$key] = $value;

        return $this;
    }

    public function write($path, $quote = false)
    {
        $res = array();

        foreach($this->ini as $key => $val)
        {
            if(is_array($val))
            {
                $res[] = $key;

                foreach($val as $skey => $sval)
                {
                    $res[] = $skey.'='.(($quote) ? "\"$sval\"" : $sval);
                }
            }
            else
            {
                $res[] = $key.'='.(($quote) ? "\"$val\"" : $val);
            }
        }

        $buffer = implode("\n", $res);

        if(false == file_put_contents($path, $buffer))
            throw new DomainException(sprintf(
                '%s - can not write the ini file to: %s'
                , __METHOD__, $path
            ));

        return $this;
    }
}
