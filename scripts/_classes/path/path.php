<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/29/12
 * Time: 2:59 AM
 * To change this template use File | Settings | File Templates.
 */

abstract class JdlPath
{
    public static function join()
    {
        return implode(DIRECTORY_SEPARATOR, func_get_args());
    }
}
