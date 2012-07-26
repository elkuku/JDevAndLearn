<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/22/12
 * Time: 6:30 PM
 * To change this template use File | Settings | File Templates.
 */

class DalConfigGit
{
    /**
     * @static
     *
     * @param $path
     *
     * @throws DomainException
     *
     * @return array
     */
    public static function getInfo($path)
    {
        if(false == file_exists(($path.'/.gitconfig')))
            throw new DomainException('No .gitconfig found in path: '.$path);

        $config = parse_ini_file($path.'/.gitconfig', 1);

        if(false == $config)
            throw new DomainException('Something wrong with you .gitconfig file in '.$path);

        return $config;
    }

    public static function write($path, array $values)
    {
        $s = array();

        foreach($values as $key => $val)
        {
            if(is_array($val))
            {
                $s[] = "[$key]";

                foreach($val as $skey => $sval)
                {
                    $s[] = "\t$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
                }
            }
            else
            {
                $s[] = "\t$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
            }
        }

        $content = implode("\n", $s);

        if(false == JFile::write($path.'/.gitconfig', $content))
            throw new DomainException(sprintf('%s - Can not write the file: %s'
                , __METHOD__, $path.'/.gitconfig'));

        echo implode("\n", $s);
    }

}
