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
define('JPATH_SITE', JPATH_BASE);

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
class JdlDistrobackup extends KukuApplicationCli
{
    private $backupDir;

    private $backupName = '';

    /**
     * @var SimpleXMLElement
     */
    private $backups = null;

    private $tmpDir = '';

    /**
     * @var SimpleXMLElement
     */
    private $xmlConfig = null;

    /**
     * Execute the application.
     *
     * The 'execute' method is the entry point for a command line application.
     *
     *
     * @throws UnexpectedValueException
     * @throws DomainException
     * @return void
     */
    public function doExecute()
    {
        $this->outputTitle('JDL Distro backup')
            ->setup()
            ->output('Backup to: ', false)
            ->output($this->backupDir, true, 'yellow', '', 'bold');

        $HOME = exec('echo $HOME');

        /* @var SimpleXMLElement $backup */
        foreach($this->backups->backup as $backup)
        {
            $destFolder = trim((string)$backup->attributes()->title);

            if('' == $destFolder)
            {
                $this->output('Please specify a "title" attribute in the backup section of your config.xml', true, 'red');

                continue;
            }

            $baseFolder = trim((string)$backup->attributes()->base);

            if('' == $baseFolder)
            {
                $this->output('Please specify a "base" attribute in the backup section of your config.xml', true, 'red');

                continue;
            }

            if(0 === strpos($baseFolder, '~'))
                $baseFolder = $HOME.substr($baseFolder, 1);

            $this->output()->output($destFolder, true, 'green');

            foreach($backup->folder as $folder)
            {
                $this->backupFolder($baseFolder, $destFolder, (string)$folder);
            }

            foreach($backup->file as $file)
            {
                $this->backupFile($baseFolder, $destFolder, $file);
            }

            $fileName = $destFolder.'-'.$this->backupName.'.tar.gz';

            $this->output('Creating archive: '.$fileName.'...', false);

            exec('cd "'.$this->tmpDir.'/'.$destFolder.'"'
            .' && tar czf "'.$this->tmpDir.'/'.$fileName.'"'
            .' .');

            $md5 = md5_file($this->tmpDir.'/'.$fileName);

            JFile::write($this->tmpDir.'/md5/'.$this->backupName.'-'.$destFolder.'.md5', $md5);

            $this->output('ok', true, 'green');

            JFolder::delete($this->tmpDir.'/'.$destFolder);
        }

        $this->output()->output('Creating main archive...', false, 'yellow');

        exec('cd "'.$this->backupDir.'"'
            .' && tar czf "'.$this->backupDir.'/'.$this->backupName.'.tar.gz"'
            .' "'.$this->backupName.'"');

        $this->output('ok', true, 'green');

        JFolder::delete($this->tmpDir);

        $this->output()->output('Backup file has been written to: ', false)
            ->output($this->backupDir.'/'.$this->backupName.'.tar.gz', true, 'yellow', '', 'bold');

        $this->output()->output('Finished =;)', true, 'green')->output();
    }

    private function backupFolder($base, $dest, $folder)
    {
        $f = (string)$folder;

        $this->output('Folder: ', false);

        $path = $base.'/'.$f;

        if(false == is_dir($path))
        {
            $this->output($path.' - NOT FOUND', true, 'red', '', 'bold');

            return $this;
        }

        $this->output($path, true, '', '', 'bold');

        $dst = $this->tmpDir.'/'.$dest.'/'.$f;

        if(false == JFolder::copy($path, $dst))
            throw new DomainException(sprintf('Can not copy the folder %s to %s', $path, $dst));

        return $this;
    }

    private function backupFile($base, $dest, $file)
    {
        $path = $base.'/'.$file;

        $this->output('File: ', false);

        if(false == file_exists($path))
        {
            $this->output($path.' - NOT FOUND', true, 'red', '', 'bold');

            return $this;
        }

        $this->output($path, true, '', '', 'bold');

        $dst = $this->tmpDir.'/'.$dest.'/'.$file;

        if(false == JFolder::create(dirname($dst)))
            throw new DomainException('Can not create the folder: '.dirname($dst));

        if(false == JFile::copy($path, $dst))
            throw new DomainException(sprintf('Can not copy the folder %s to %s', $path, $dst));

        return $this;
    }

    private function setup()
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $cfgPath = realpath(__DIR__.'/..').'/config.xml';

        if(false == file_exists($cfgPath))
            throw new DomainException('ERROR: Config file not found at:'.$cfgPath);

        $this->xmlConfig = simplexml_load_file($cfgPath);

        if(false == $this->xmlConfig)
            throw new DomainException('ERROR: Invalid config at:'.$cfgPath);

        $this->backupDir = (string)$this->xmlConfig->global->backupDir;//trim($this->get('backupDir'));

        if('' == trim($this->backupDir))
            throw new UnexpectedValueException('Please specify a backup directory in configuration.php');

        if(false == is_dir($this->backupDir))
            throw new UnexpectedValueException('The backup directory specified in configuration.php does not exist');

        $this->backups = $this->xmlConfig->backups;

        $this->backupName = time().'---'.date((string)($this->backups->backupTimestamp));

        $this->tmpDir = $this->backupDir.'/'.$this->backupName;

        if(JFolder::exists($this->tmpDir) && false === JFolder::delete($this->tmpDir))
            throw new DomainException('Can not clean the tmp dir');

        if(false === JFolder::create($this->tmpDir))
            throw new DomainException('Can not create the tmp dir');

        JFolder::create($this->tmpDir.'/md5');

        return $this;
    }
}

/*
 * Main routine ----->
 */

try
{
    JApplicationCli::getInstance('JdlDistrobackup')->execute();
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
