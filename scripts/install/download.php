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

require dirname(__DIR__) . '/bootstrap.php';

/**
 * JDL IDE downloader class.
 *
 * @package JdlInstall
 */
class JdlInstall extends JdlApplicationCli
{
	/**
	 * Execute the application.
	 *
	 * @throws UnexpectedValueException
	 * @throws JdlExceptionIncomplete
	 * @throws Exception
	 *
	 * @return void
	 */
	public function doExecute()
	{
		try
		{
			$this->outputTitle('IDE Download and Install');

			$home = exec('echo $HOME');

			$downloadDir = $this->configXml->global->downloadDir;

			if (false == is_dir($downloadDir))
				throw new JdlExceptionIncomplete('Please create the download directory at: ' . $downloadDir, 1);

			if ($this->input->get('list'))
			{
				$this->listApps();

				return;
			}

			if ($this->input->get('h', $this->input->get('help')))
				throw new JdlExceptionIncomplete;

			$appName = $this->input->get('app');

			if ('' == $appName)
				throw new JdlExceptionIncomplete('Please specify an application using the option --app');

			$apps = $this->fetchApps();

			if (false == array_key_exists($appName, $apps))
				throw new UnexpectedValueException('The application you requested could not be found', 1);

			$app = $apps[$appName];

			$uri = trim(sprintf($app->downloadUri, $app->version));

			if (false == $uri)
				throw new UnexpectedValueException('Invalid application - no uri given', 1);

			$fileName = $app->fileName ? : substr($uri, strrpos($uri, '/') + 1);

			$CD = 'cd "' . $downloadDir . '"';

			if (file_exists($downloadDir . '/' . $fileName))
			{
				//$this->output('The file already exists.', true, 'green');
				$msg = 'The file already exists. Do you want to reinstall ?';

				exec('kdialog --title "Install" --yesno "'.$msg.'"', $output, $retval);

				if($retval)
				{
					$this->outputTitle('Abort :(', 'yellow');

					return;
				}
			}
			else
			{
				$msg = $app->description . "\n\nDo you wish to continue ?";

				exec('kdialog --title "Install" --yesno "'.$msg.'"', $output, $retval);

				if($retval)
				{
					$this->outputTitle('Abort :(', 'yellow');

					return;
				}

				$this
					->output('Download   : ' . $uri)
					->output('Download to:' . $downloadDir . '/' . $fileName)
					->output()
					->output('Downloading...', false)
					->output('Please wait !', true, 'green', '', 'bold');

				$forceFileName = $app->fileName ? ' -O ' . $app->fileName : '';

				passthru($CD . ' && wget "' . $uri . '"' . $forceFileName, $retVar);

				if (0 != $retVar)
					throw new Exception('wget finished with exit code: ' . $retVar, $retVar);
			}

			$ext = substr($fileName, strrpos($fileName, '.') + 1);

			switch ($ext)
			{
				case 'sh':
					$this->output('Executing the installer...', false);

					exec($CD . ' && chmod +x "' . $fileName . '" && ./"' . $fileName . '"');

					$this->output('ok', true, 'green');

					break;

				case 'gz' :
					$test = substr($fileName, 0, strrpos($fileName, '.'));
					$testE = substr($test, strrpos($test, '.') + 1);

					if ('tar' != $testE)
						throw new Exception('Unknown extension in file: ' . $fileName);

					$destPath = ($app->destPath) ? ' -C ' . $app->destPath : '';

					$this->output('Unzipping to ' . ($destPath ? : $downloadDir) . '...', false);

					exec($CD . ' && tar -xzvf ' . $fileName . $destPath . ' 2>&1', $output, $retval);

					$this->output('ok', true, 'green');

					if ($retval)
						throw new Exception(print_r($output, 1), $retval);
					break;

				default :
					throw new Exception('Unknown extension: ' . $ext, 1);
			}

			$path = $home.'/Desktop/Scripts/IDEs/'.$app->name.'.desktop';

			$ini = new JdlProcessorIni($path);

			$ini->set('Name[en_US]', $app->title, '[Desktop Entry]');
			$ini->set('Name', $app->title, '[Desktop Entry]');

			//$ini->set('Terminal', 'true', '[Desktop Entry]');
			$ini->set('Terminal', 'false', '[Desktop Entry]');
			//$ini->set('TerminalOptions', '\s--noclose', '[Desktop Entry]');
			$ini->set('TerminalOptions', '', '[Desktop Entry]');

			$ini->write($path);

			$this->output()
				->output('Your may execute the application now from your beakermenu.', 'true', 'yellow', '', 'bold')
				->output()
				->outputTitle('Finished =;)', 'green');

		}
		catch (JdlExceptionIncomplete $e)
		{
			$msg = $e->getMessage();

			if ($msg) $this->outputTitle($e->getMessage(), 'yellow');

			$this->output()
				->help();
		}
	}

	private function fetchApps()
	{
		$apps = array();

		foreach ($this->configXml->install->application as $app)
		{
			$apps[(string) $app->name] = $app;
		}

		return $apps;
	}

	private function listApps()
	{
		$this->output('Application List', true, 'yellow', '', 'bold')
			->out();

		foreach ($this->fetchApps() as $app)
		{
			$this->output('== ' . $app->title . ' ==', true, '', '', 'bold')
				->output('Alias:         ' . $app->name)
				->output('Version:       ' . $app->version)
				->output('Download from: ' . trim(sprintf($app->downloadUri, $app->version)))
				->output('Install to:    ' . $app->destPath)
				->output()
				->output($app->description)
				->output();
		}
	}

	private function help()
	{
		$exe = substr($this->input->executable, strrpos($this->input->executable, '/') + 1);

		$this->output('Usage', true, 'yellow', '', 'bold')
			->out()
			->output($exe . ' --app <application name>')
			->out()
			->output($exe . ' <option>')
			->out()
			->output('Options', true, '', '', 'bold')
			->out('--help   -h  This help.')
			->out('--list       Show available applications.');
	}
}

/*
 * Main routine
 */
try
{
	JApplicationCli::getInstance('JdlInstall')->execute();
}
catch (Exception $e)
{
	if (COLORS)
	{
		$color = new Console_Color2;

		$msg = $color->color('red', null, 'grey')
			. 'Error: ' . $e->getMessage()
			. $color->color('reset')
			. NL;
	}
	else
	{
		$msg = 'ERROR: ' . $e->getMessage() . NL;
	}

	echo $msg;

	echo NL . $e->getTraceAsString() . NL;

	exit($e->getCode() ? : 1);
}
