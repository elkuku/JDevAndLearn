#!/usr/bin/env php
<?php
/**
 * @package    JDevAndLearn
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 16-Jun-2012
 * @license    GNU/GPL
 */

// We are a valid Joomla entry point.
// This is required to load the Joomla Platform import.php file.
define('_JEXEC', 1);

// Setup the base path related constant.
define('JPATH_BASE', dirname(__FILE__));

define('JPATH_SITE', JPATH_BASE);

define('JDLPATH_SCRIPTS', dirname(__DIR__));

define('NL', "\n");

const ERR_TEST = 66;

const ERR_REQ = 2;

const ERR_DOMAIN = 10;

// Increase error reporting to that any errors are displayed.
// Note, you would not use these settings in production.
error_reporting(- 1);
ini_set('display_errors', true);

// Bootstrap the application.
require getenv('JOOMLA_PLATFORM_PATH').'/libraries/import.php';

require JDLPATH_SCRIPTS.'/_classes/loader.php';

/**
 * An example command line application class.
 *
 * This application shows how to access configuration file values.
 *
 * @package  JdlUpdateRepos
 */
class JdlRepoStatus extends JdlApplicationCli
{
    private $repoBase = '';

    private $gitPath = '';

    /**
     * Execute the application.
     *
     * @throws Exception
     * @throws UnexpectedValueException
     * @throws DomainException
     * @return void
     */
    public function doExecute()
    {
        jimport('joomla.filesystem.folder');

        $this->setup();

        $this->outputTitle('Repository Status')
            ->output('Repository Path: '.$this->repoBase);

        $folders = JFolder::folders($this->repoBase);

        $excludes = array();

        foreach($this->configXml->updates->statusExcludes->exclude as $exclude)
        {
            $excludes[] = (string) $exclude;
        }

        foreach($folders as $folder)
        {
            //-- Check if it is a git repo
            if(false == JFolder::exists($this->repoBase.'/'.$folder.'/.git'))
                continue;

            if(in_array($folder, $excludes))
                continue;

            $this->output()
                ->output($folder, true, '', '', 'bold');

            $cmd = 'cd "'.$this->repoBase.'/'.$folder.'" && git status -sb 2>&1';

            passthru($cmd, $ret);

            if(0 !== $ret)
                throw new DomainException('Something went wrong pulling the repo', ERR_DOMAIN);
        }

        $this->output(sprintf('Execution time: %s secs.'
            , time() - $this->get('execution.timestamp')));

        $this->output()
            ->output('Finished =;)', true, 'green');

        if(1)
        {
            $this->output()
                ->output('You may close this window now.', true, 'red', '', 'bold');
        }
    }

    private function setup()
    {
        $this->repoBase = $this->configXml->global->repoDir;

        if(! $this->repoBase || ! JFolder::exists($this->repoBase))
            throw new DomainException('Invalid repository base', ERR_DOMAIN);

        if('' == $this->gitPath)
        {
            exec('which git 2>/dev/null', $output, $ret);

            if(0 !== $ret)
                throw new UnexpectedValueException('Git must be installed to run this script', ERR_REQ);

            $this->gitPath = 'git';//$output
        }

        return $this;
    }
}

//-- Main routine

try
{
    JApplicationCli::getInstance('JdlRepoStatus')->execute();
}
catch(Exception $e)
{
    if(defined(COLORS) && COLORS)
    {
        $color = new Console_Color2;

        echo $color->color('red', null, 'grey')
            .' Error: '.$e->getMessage().' '
            .$color->color('reset')
            .NL;
    }
    else
    {
        echo 'ERROR: '.$e->getMessage().NL;
    }

    echo NL.$e->getTraceAsString().NL;

    exit($e->getCode() ? : 1);
}
