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

// We are a valid Joomla! entry point.
define('_JEXEC', 1);

require dirname(__DIR__).'/bootstrap.php';

/**
 * JDL Db backup class.
 *
 * @package JdlInstall
 */
class JdlStartup extends JdlApplicationCli
{
    /**
     * Execute the application.
     *
     * @throws UnexpectedValueException
     * @throws DomainException
     * @return void
     */
    public function doExecute()
    {
	    $HOME = exec('echo $HOME');

	    if(JFile::exists($HOME.'/.pdlfirstrun'))
		    return;

	    $backupDir = $HOME.'/srv/data/backups';

	    $this->outputTitle('JDL Startup')
		    ->setup()
		    ->output('Backup to: ', false)
		    ->output($backupDir, true, 'yellow', '', 'bold');

	    $files = JFolder::files($backupDir, '.', false, true);

	    foreach ($files as $file)
	    {
		    $command = 'mysql -u root < '.$file.' 2>&1';

		    $this->out($command);

		    $this->output('Importing file: ', false)
			    ->output($file.'...', false, 'yellow');

		    exec($command);

            $this->output('ok', true, 'green');
        }

	    $contents = '=;)';

	    JFile::write($HOME . '/.pdlfirstrun', $contents);

        $this->output()->outputTitle('Finished =;)', 'green')->output();
    }

    private function setup()
    {
	    return $this;
    }
}

/*
 * Main routine ----->
 */

try
{
    JApplicationCli::getInstance('JdlStartup')->execute();
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
