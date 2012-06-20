<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/19/12
 * Time: 2:34 AM
 * To change this template use File | Settings | File Templates.
 */

spl_autoload_register('jdlLibLoader', true, true);

function jdlLibLoader($name)
{
    if(0 !== strpos($name, 'Jdl'))
        return;

    $parts = preg_split('/(?<=[a-z])(?=[A-Z])/x', substr($name, 3));

    $path = __DIR__.'/'.strtolower(implode('/', $parts)).'.php';

    if(file_exists($path))
    {
        include $path;

        return;
    }
}
