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
 * JDL repository status class.
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
		$this->outputTitle('Start IDE');

		try
		{
			if (false == isset($this->input->args[0]))
				throw new JdlExceptionIncomplete;

			$ideR = $this->input->args[0];
			$ides = $this->fetchIDEs();

			if (false == array_key_exists($ideR, $ides))
				throw new UnexpectedValueException('Unknown IDE: ' . $ideR);

			$ide = $ides[$ideR];

			$user = exec('whoami');

			$idePath = $ide->destPath . '/' . $ide->folderName;
			$idePath = str_replace('~', '/home/' . $user, $idePath);

			$this->output(sprintf('IDE: %s in path "%s"', $ide->title, $idePath));

			if (false == is_dir($idePath))
			{
				passthru(JPATH_BASE . '/install/download.php --app ' . $ide->name, $retVal);

				if (0 !== $retVal)
					return;
			}

			$scriptPath = '/home/' . $user . '/bin/' . $ide->name;

			if (false == file_exists($scriptPath))
				throw new UnexpectedValueException('Start script not found: ' . $scriptPath);

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

		$this->output('Usage', true, 'yellow', '', 'bold')
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
	JApplicationCli::getInstance('JdlStartIDE')->execute();
}
catch (Exception $e)
{
	if (COLORS)
	{
		$color = new Console_Color2;

		echo $color->color('red', null, 'grey')
			. ' Error: ' . $e->getMessage() . ' '
			. $color->color('reset')
			. NL;
	}
	else
	{
		echo 'ERROR: ' . $e->getMessage() . NL;
	}

	echo NL . $e->getTraceAsString() . NL;

	exit($e->getCode() ? : 1);
}
