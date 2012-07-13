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
	 * @throws Exception
	 *
	 * @return void
	 */
	public function doExecute()
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		try
		{
//		echo $this->get('cwd');

			$langPath = $this->get('cwd');

			$langPath = $langPath . '/../cli_languages';

			$l = realpath($langPath);

			if (!$l)
				throw new UnexpectedValueException(jgettext('Please create the directory %s for your lnguage files.')
					, $langPath);

			$langPath = $l;

			var_dump($this->input->args);

			$command = (isset($this->input->args[0])) ? $this->input->args[0] : '';
			$inputFile = (isset($this->input->args[1])) ? $this->input->args[1] : '';

			$projectName = JFile::stripExt($inputFile);


			if ('' == $command || '' == $inputFile)
				throw new IncompleteException;

			$keywords = ' -k --keyword=jgettext --keyword=jngettext:1,2';

			$forcePo = ' --force-po';
			$noWrap = ' --no-wrap';
			$comments = ' --add-comments=TRANSLATORS:';
			$copyright = " --copyright-holder=\"Nikolai Plath - elkuku\"";
			$packageName = " --package-name=\"com_easycreator\"";
			$packageVersion = ' --package-version="0.0.18"';
			$msgidBugs = ' --msgid-bugs-address="der.el.kuku@gmail.com"';

			//	$output = $this->input->get('o', $this->input->get('output'));

			//	if ('' == $output)
			//		throw new UnexpectedValueException('Please specify the output file with -o (--output)');

			//	$input = $this->input->get('i', $this->input->get('input'));

			//	if ('' == $input)
			//		throw new UnexpectedValueException('Please specify the input file with -i (--input)');


			var_dump($command, $inputFile);
			switch ($command)
			{
				case 'template' :
					$outputFile = sprintf($langPath . '/cli_%1$s/g11n/template/%1$s.pot', $projectName);
//					var_dump($outputFile);

					JFolder::create(dirname($outputFile));

					$cmd = "xgettext$keywords$forcePo$noWrap$comments$copyright$packageName$packageVersion$msgidBugs"
						. " -o \"$outputFile\" -i \"$inputFile\"";
					break;

				case 'language' :
					$lang = (isset($this->input->args[2])) ? $this->input->args[2] : '';

					if ('' == $lang)
						throw new IncompleteException;

					$inputFile = sprintf($langPath . '/cli_%1$s/g11n/template/%1$s.pot', $projectName);

					$outputFile = sprintf($langPath . '/cli_%1$s/g11n/%2$s/%2$s.%1$s.po', $projectName, $lang);

					if (JFile::exists($outputFile))
					{
						$cmd = "msgmerge -U $outputFile $inputFile";
					}
					else
					{
						JFolder::create(dirname($outputFile));

						$cmd = "msginit -i $inputFile -o $outputFile";
					}

					break;

				default :
					throw new IncompleteException;
					break;
			}

			$cmd = escapeshellcmd($cmd);

			exec($cmd, $output, $retVar);

			if (0 != $retVar)
				throw new Exception(implode("\n", $output), 1);

			$this->output(jgettext('Finished =;)'), true, 'green');
		}
		catch (IncompleteException $e)
		{
			$this->help();
		}
	}

	private function help()
	{
		$this->output('Usage:')
			->output('makelang <command> <inputfile> [lang-tag]');

		/*
		 * makelang template foo.php
		 * makelang language foo.php xx-XX
		 *
		 */

		return $this;
	}

	private function setup()
	{
		return $this;
	}
}

class IncompleteException extends Exception
{
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
