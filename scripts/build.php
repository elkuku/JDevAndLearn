#!/usr/bin/env php
<?php
/**
 * @package    JDevAndLearn
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 14-Jul-2012
 * @license    GNU/GPL
 */

// We are a valid Joomla!entry point.
define('_JEXEC', 1);

require 'bootstrap.php';

/**
 * JDL start IDE class.
 *
 * @package  JdlUpdateRepos
 */
class PdbBuild extends JdlApplicationCli
{
	private $targets = array(
		'language',
	);

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
		jimport('joomla.filesystem.path');

		//g11n::cleanStorage('cli_startide');

		g11n::loadLanguage('cli_startide');

		$this->outputTitle(jgettext('PDB Builder'));

		try
		{
			$target = isset($this->input->args[0]) ? $this->input->args[0] : '';

			if ('' == $target)
			{
				foreach ($this->targets as $target)
				{
					$this->{'build' . $target}();
				}
			}
			else
			{
				if (false == in_array($target, $this->targets))
					throw new UnexpectedValueException('Invalid target');

				$this->{'build' . $target}();
			}
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
			->output($exe . ' [target]');
	}

	private function buildLanguage()
	{
		echo 'buildLanguage';
	}
}

//-- Main routine

try
{
	$application = JApplicationCli::getInstance('PdbBuild');

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
