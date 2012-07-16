#!/usr/bin/env php
<?php
/**
 * @package    JdlInstall
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 15-Jun-2012
 * @license    GNU/GPL
 */

/*
FILELIST
	|
	 xgettext
	-k
	--keyword=jgettext
	--keyword=jngettext:1,2
	-o /home/jtester/srv/www/web_jdevlearn/administrator/components/com_easycreator/g11n/templates/com_easycreator.pot
	--force-po
	--no-wrap
	--add-comments=TRANSLATORS:
	--copyright-holder="Nikolai Plath - elkuku"
	--package-name="com_easycreator"
	--package-version="0.0.18"
	--msgid-bugs-address="der.el.kuku@gmail.com"
	-f
	-
	2>&1


	*/

'cli' == PHP_SAPI || die('This script must be run from the command line.');

// We are a valid Joomla! entry point.
define('_JEXEC', 1);

require dirname(__DIR__) . '/bootstrap.php';

/**
 * JDL Db backup class.
 *
 * @package JdlInstall
 */
class MakeLang extends JdlApplicationCli
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
		$this->outputTitle(jgettext('MakeLang - A language maker'));

		try
		{
			if ($this->input->get('help', $this->input->get('h')))
				throw new JdlExceptionIncomplete;

			$langPath = $this->get('cwd');

			$langPath = $langPath . '/../cli_languages';

			$l = realpath($langPath);

			if (!$l)
				throw new UnexpectedValueException(sprintf(
						jgettext('Please create the directory "%s" for your language files.')
						, $langPath)
					, 1);

			$langPath = $l;

			$command = (isset($this->input->args[0])) ? $this->input->args[0] : '';
			$inputFile = (isset($this->input->args[1])) ? $this->input->args[1] : '';

			$projectName = JFile::stripExt($inputFile);

			if ('' == $command || '' == $inputFile)
				throw new JdlExceptionIncomplete;

			$keywords = ' -k --keyword=jgettext --keyword=jngettext:1,2';

			// @todo: Maybe some other credits =;P
			$forcePo = ' --force-po';
			$noWrap = ' --no-wrap';
			$comments = ' --add-comments=TRANSLATORS:';
			$copyright = " --copyright-holder=\"Nikolai Plath - elkuku\"";
			$packageName = " --package-name=\"PHP DevBox\"";
			$packageVersion = ' --package-version="0.0.1"';
			$msgidBugs = ' --msgid-bugs-address="der.el.kuku@gmail.com"';

			switch ($command)
			{
				case 'template' :
					$outputFile = sprintf($langPath . '/cli_%1$s/g11n/template/cli_%1$s.pot', $projectName);

					JFolder::create(dirname($outputFile));

					$this->output(sprintf(jgettext('Creating the template: "%s"'), $outputFile));

					$cmd = "xgettext$keywords$forcePo$noWrap$comments$copyright$packageName$packageVersion$msgidBugs"
						. " -o \"$outputFile\" -i \"$inputFile\"";
					break;

				case 'language' :
					$lang = (isset($this->input->args[2])) ? $this->input->args[2] : '';

					if ('' == $lang)
						throw new JdlExceptionIncomplete;

					$inputFile = sprintf($langPath . '/cli_%1$s/g11n/template/cli_%1$s.pot', $projectName);

					$outputFile = sprintf($langPath . '/cli_%1$s/g11n/%2$s/%2$s.cli_%1$s.po', $projectName, $lang);

					if (JFile::exists($outputFile))
					{
						$this->output(sprintf(jgettext('Updating the language file: "%s"'), $outputFile));

						$cmd = "msgmerge -U $outputFile $inputFile";
					}
					else
					{
						$this->output(sprintf(jgettext('Creating the language file: "%s"'), $outputFile));

						JFolder::create(dirname($outputFile));

						$cmd = "msginit -i $inputFile -o $outputFile";
					}

					break;

				default :
					throw new JdlExceptionIncomplete;
					break;
			}

			$cmd = escapeshellcmd($cmd);

			exec($cmd, $output, $retVar);

			if (0 != $retVar)
				throw new Exception(implode("\n", $output), 1);

			$this->output(jgettext('Finished =;)'), true, 'green');
		}
		catch (JdlExceptionIncomplete $e)
		{
			$this->help();
		}
	}

	private function help()
	{
		$this->output('Usage:', true, 'green')
			->output('makelang <command> <inputfile> [lang-tag]')
			->output()
			->output('Commands:', true, 'green')
			->output('template', false, 'yellow')->output(' - Create a language template')
			->output('language', false, 'yellow')->output(' - Create a language file from a template')
			->output()
			->output('Examples:', true, 'green')
			->output()
			->output('makelang template foo.php', true, '', '', 'bold')
			->output('Create the template "foo.pot" containing the language strings from "foo.php"')
			->output()
			->output('makelang language foo.pot xx-XX', true, '', '', 'bold')
			->output('Create or update the language file "xx-XX.foo.po" with the strings from "foo.pot"');

		return $this;
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
	$application = JApplicationCli::getInstance('MakeLang');

	JFactory::$application = $application;

	$application->execute();
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
