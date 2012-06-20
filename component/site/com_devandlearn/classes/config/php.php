<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 4:53 PM
 * To change this template use File | Settings | File Templates.
 */

class DalConfigPhp
{
    /**
     * method to get the PHP info
     *
     * @return string PHP info
     */
    public static function getPHPInfo()
    {

            ob_start();
        //    date_default_timezone_set('UTC');
            phpinfo(INFO_GENERAL | INFO_CONFIGURATION | INFO_MODULES);
            $phpinfo = ob_get_contents();
            ob_end_clean();

            preg_match_all('#<body[^>]*>(.*)</body>#siU', $phpinfo, $output);

        $tableClass = 'table table-striped table-bordered table-condensed';

            $output = preg_replace('#<table[^>]*>#', '<table class="'.$tableClass.'">', $output[1][0]);
            $output = preg_replace('#(\w),(\w)#', '\1, \2', $output);
            $output = preg_replace('#<hr />#', '', $output);
            $output = str_replace('<div class="center">', '', $output);
            $output = preg_replace('#<tr class="h">(.*)<\/tr>#', '<thead><tr class="h">$1</tr></thead><tbody>', $output);
            $output = str_replace('</table>', '</tbody></table>', $output);
            $output = str_replace('</div>', '', $output);

            return $output;
    }

}
