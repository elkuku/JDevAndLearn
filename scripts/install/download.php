#!/usr/bin/env php
<?php
/**
 * @package    JdlInstall
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 15-Jun-2012
 * @license    GNU/GPL
 */

'cli' == PHP_SAPI || die('This script must be run from the command line.');

// We are a valid Joomla entry point.
// This is required to load the Joomla Platform import.php file.
define('_JEXEC', 1);

define('NL', "\n");

// Setup the base path related constant.
// This is one of the few, mandatory constants needed for the Joomla Platform.
define('JPATH_BASE', dirname(__FILE__));

// Increase error reporting to that any errors are displayed.
// Note, you would not use these settings in production.
error_reporting(- 1);
ini_set('display_errors', true);

// Bootstrap the application.
require getenv('JOOMLA_PLATFORM_PATH').'/libraries/import.php';

require getenv('KUKU_JLIB_PATH').'/loader.php';

/**
 * A "hello world" command line application class.
 *
 * Simple command line applications extend the JApplicationCli class.
 *
 * @package JdlInstall
 */
class JdlInstall extends KukuApplicationCli
{
    /**
     * Execute the application.
     *
     * The 'execute' method is the entry point for a command line application.
     *
     * @throws Exception
     * @return void
     */
    public function doExecute()
    {
        $this->outputTitle('Install/Download');

        $cfgPath = realpath(__DIR__.'/..').'/config.xml';

        file_exists($cfgPath) || die ('ERROR: Config file not found at:'.$cfgPath);

        $config = simplexml_load_file($cfgPath);

        if(false == $config) die('ERROR: Invalid config at:'.$cfgPath);

        $home = exec('echo $HOME');

        $downloadDir = $home.'/downloads1';

        if(false == is_dir($downloadDir))
            throw new Exception('Please create the download directory at: '.$downloadDir, 1);

        $appName = 'netbeans';
        $appName = 'phpstorm';

        $uri = false;

        foreach($config->install->application as $app)
        {
            if($appName != (string)$app->name)
                continue;

            $uri = trim(sprintf($app->downloadUri, $app->version));

            if(false == $uri) throw new Exception('Invalid application', 1);

            $fileName = substr($uri, strrpos($uri, '/') + 1);

            //$this->output('Filename:' . $fileName);

            $cd = 'cd "'.$downloadDir.'" &&';

            if(file_exists($downloadDir.'/'.$fileName))
            {
                $this->output('The file already exists.', true, 'green');
            }
            else
            {
                $this
                    ->output('Download   : '.$uri)
                    ->output('Download to:'.$downloadDir.'/'.$fileName)
                    ->output()
                    ->output('Downloading...', false)
                    ->output('Please wait !', true, 'green', '', 'bold');

                passthru($cd.' wget "'.$uri.'"', $retVar);

                if($retVar)
                    throw new Exception('wget finished with exit code: '.$retVar, $retVar);
            }

            $ext = substr($fileName, strrpos($fileName, '.') + 1);

            switch($ext)
            {
                case 'sh':
                    $this->output('Executing the installer...', false);

                    exec($cd.' chmod +x "'.$fileName.'" && ./"'.$fileName.'"');

                    $this->output('ok', true, 'green');

                    break;

                case 'gz' :
                    $test = substr($fileName, 0, strrpos($fileName, '.'));
                    $testE = substr($test, strrpos($test, '.') + 1);

                    if('tar' != $testE)
                        throw new Exception('Unknown extension in file: '.$fileName);

                    $this->output('Unzipping to '.$downloadDir.'...', false);

                    exec($cd.' tar -xzvf '.$fileName, $output, $retval);

                    $this->output('ok', true, 'green');

                    if($retval)
                        throw new Exception('tar: '.print_r($output, 1), $retval);
                    break;

                default :
                    throw new Exception('Unknown extension: '.$ext, 1);
            }

            $this->output()
                ->output('Finished =;)', true, 'green', '', 'bold');
        }

        if(false == $uri) throw new Exception('Invalid application', 1);
    }

}

try
{
    JApplicationCli::getInstance('JdlInstall')->execute();
}
catch(Exception $e)
{
    if(COLORS)
    {
        $color = new Console_Color2;

        $msg = $color->color('red', null, 'grey')
            .'Error: '.$e->getMessage()
            .$color->color('reset')
            .NL;
    }
    else
    {
        $msg = 'ERROR: '.$e->getMessage().NL;
    }

    echo $msg;

    echo NL.$e->getTraceAsString().NL;

    exit($e->getCode() ? : 1);
}
