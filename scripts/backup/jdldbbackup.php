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

// We are a valid Joomla!entry point.
define('_JEXEC', 1);

require dirname(__DIR__).'/bootstrap.php';

/**
 * JDL Db backup class.
 *
 * @package JdlInstall
 */
class JdlDbBackup extends JdlApplicationCli
{
    private $backupDir;

    private $backupName = '';

    /**
     * @var SimpleXMLElement
     */
    private $backups = null;

    private $tmpDir = '';

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
	    $HOME = exec('echo $HOME');


	    $this->outputTitle('JDL Db Backup')
            ->setup()
            ->output('Backup to: ', false)
            ->output($this->backupDir, true, 'yellow', '', 'bold');

//	    $ff = JFolder::folders($HOME.'/srv/www/web_jdevlearn');

//	    exec('cp -r "'.$HOME . '/srv/www/web_jdevlearn" "'. $HOME . '/srv/www/web_jdevlearn2"');

//	    var_dump($ff);
	//    var_dump($this->configXml);

	    $this->out('TEMP: ' . $this->tmpDir);

	    foreach ($this->configXml->backups->database as $database)
	    {
		    $this->out($database);
	   //}


//	    return;


        /* @var SimpleXMLElement $backup */
       // foreach($this->backups->backup as $backup)
        //{
     //       $destFolder = trim((string)$backup->attributes()->title);


            $fileName = $database.'.sql';

		    $compact = ' --compact';
		    $compact = '';


		    $command = 'mysqldump -u root --add-drop-database'.$compact.' --databases '.$database.' > '.$this->tmpDir.'/'.$fileName.' 2>&1';

		   // $this->out($command);

		    $this->output('Backup database: ', false)
			    ->output($database.'...', false, 'yellow');

		    exec($command);

		    /*
            exec('cd "'.$this->tmpDir.'/'.$destFolder.'"'
            .' && tar czf "'.$this->tmpDir.'/'.$fileName.'"'
            .' .');
		    */

            $md5 = md5_file($this->tmpDir.'/'.$fileName);

            JFile::write($this->tmpDir.'/md5/'.$database.'.md5', $md5);

            $this->output('ok', true, 'green');

            //JFolder::delete($this->tmpDir.'/'.$destFolder);
        }

        $this->output()->output('Creating main archive...', false, 'yellow', '', 'bold');

	    $fileName = $this->backupName.'-databases.tar.gz';

        exec('cd "'.$this->backupDir.'/'.$this->backupName.'"'
            .' && tar czf "'.$this->backupDir.'/'.$fileName.'"'
            .' "."');

        $this->output('ok', true, 'green');

        //JFolder::delete($this->tmpDir);

        $this->output()->output('Backup file has been written to: ', false)
            ->output($fileName, true, 'yellow', '', 'bold');

        $this->output()->outputTitle('Finished =;)', 'green')->output();
    }

    private function setup()
    {
	    jimport('joomla.filesystem.folder');
	    jimport('joomla.filesystem.file');

	    $this->backupDir = (string)$this->configXml->global->backupDir;

	    if('' == trim($this->backupDir))
		    throw new UnexpectedValueException('Please specify a backup directory in configuration.php');

	    if(false == is_dir($this->backupDir))
		    throw new UnexpectedValueException('The backup directory specified in configuration.php does not exist');

	    $this->backupName = time().'---'.date((string)($this->configXml->backups->backupTimestamp));

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
    JApplicationCli::getInstance('JdlDbBackup')->execute();
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
