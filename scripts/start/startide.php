#!/usr/bin/env php
<?php
/**
 * @package    JDevAndLearn
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 16-Jun-2012
 * @license    GNU/GPL
 */

// We are a valid Joomla!entry point.
define('_JEXEC', 1);

require dirname(__DIR__) . '/bootstrap.php';

/**
 * JDL start IDE class.
 *
 * @package  JdlUpdateRepos
 */
class JdlStartIDE extends JdlApplicationCli
{
	/**
	 * Execute the application.
	 *
	 * @throws UnexpectedValueException
	 * @throws JdlExceptionIncomplete
	 *
	 * @return void
	 */
	public function doExecute()
	{
		$this->outputTitle(jgettext('Start IDE'));

		try
		{
			if (false == isset($this->input->args[0]))
				throw new JdlExceptionIncomplete;

			$ideR = $this->input->args[0];
			$ides = $this->fetchIDEs();

			if (false == array_key_exists($ideR, $ides))
				throw new UnexpectedValueException(sprintf(jgettext('Unknown IDE: %s'), $ideR));

			$ide = $ides[$ideR];

			$user = exec('whoami');

			$idePath = $ide->destPath . '/' . $ide->folderName;
			$idePath = str_replace('~', '/home/' . $user, $idePath);

			$this->output(sprintf(jgettext('IDE: %s in path "%s"'), $ide->title, $idePath));

			if (false == is_dir($idePath))
			{
				passthru(JPATH_BASE . '/install/download.php --app ' . $ide->name, $retVal);

				if (0 !== $retVal)
					return;
			}

			$scriptPath = '/home/' . $user . '/bin/' . $ide->name;

			if (false == file_exists($scriptPath))
				throw new UnexpectedValueException(sprintf(jgettext('Start script not found: %s'), $scriptPath));

			exec($scriptPath . '&');
		}
		catch (JdlExceptionIncomplete $e)
		{
			$msg = $e->getMessage();

			if ($msg) $this->outputTitle($e->getMessage(), 'yellow');

			$this->output()
				->help();
		}
	}

	private function help()
	{
		$exe = substr($this->input->executable, strrpos($this->input->executable, '/') + 1);

		$this->output(jgettext('Usage'), true, 'yellow', '', 'bold')
			->output()
			->output($exe . ' <idename>');
	}

	private function fetchIDEs()
	{
		$ides = array();

		foreach ($this->configXml->install->application as $ide)
		{
			$ides[(string) $ide->name] = $ide;
		}

		return $ides;
	}
}

//-- Main routine

try
{
	$application = JApplicationCli::getInstance('JdlStartIDE');
	JFactory::$application = $application;
	$application->execute();
}
catch (Exception $e)
{
	if (COLORS)
	{
		$color = new Console_Color2;

		echo $color->color('red', null, 'grey')
			. ' ' . sprintf(jgettext('Error: %s'), $e->getMessage()) . ' '
			. $color->color('reset')
			. NL;
	}
	else
	{
		echo sprintf(jgettext('Error: %s'), $e->getMessage()) . NL;
	}

	echo NL . $e->getTraceAsString() . NL;

	exit($e->getCode() ? : 1);
}
