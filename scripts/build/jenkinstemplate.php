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
 * JDL Jenkins template class.
 *
 * @package JdlInstall
 */
class JdlJenkinstemplate extends JdlApplicationCli
{
    private $repoDir = '';

    private $projectName = '';

    private $jenkinsPath = '';

    private $templatePath = '';

    public function doExecute()
    {
        $this->outputTitle('Jenkins Template');

        $this->setup()
            ->setupRepo()
            ->setupJenkins()
	        ->output()
            ->output('Your repository is located at: ', false)
	        ->output(JdlPath::join($this->repoDir, $this->projectName), true, 'yellow', '', 'bold')
	        ->output()
	        ->outputTitle('Finished =;)', 'green');
    }

    private function setup()
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $projectName = 'JenkinsDemo';

        $this->jenkinsPath = '/home/'.exec('echo $JDL_USER').'/.jenkins';

        $this->repoDir = $this->configXml->global->repoDir;

        $this->projectName = $this->checkAvailable($this->repoDir, $projectName);

        $this->templatePath = __DIR__.'/template';

        $this->output('Project: ', false, '', '', 'bold')
            ->output($this->projectName)
            ->output('Repo: ', false, '', '', 'bold')
            ->output($this->repoDir)
            ->output('Templates: ', false, '', '', 'bold')
            ->output($this->templatePath)
            ->output();

        return $this;
    }

    private function setupRepo()
    {
        $path = $this->repoDir.'/'.$this->projectName;

        $this->output('Setting up repository in ', false, 'yellow')->output($path);

        if(false == JFolder::create($path))
            throw new DomainException(sprintf(
                '%s - Can not create the repo dir in %s'
                , __METHOD__, $path
            ));

        $CD = 'cd "'.$path.'"';

        exec($CD.' && git init 2>&1', $output, $retVal);

        if(0 !== $retVal)
            throw new DomainException(sprintf(
                '%s - Can not create the git repository in %s: %s'
                , __METHOD__, $path, implode("\n", $output)));

        $this->output(implode(NL, $output));

        unset($output);

	    $this->copyProjectFiles();

        $this->output('Performing initial commit', true, 'yellow');

        $cmd = $CD.' && git add . && git commit -m "initial import"';

        exec($cmd, $output, $retVal);

        if(0 !== $retVal)
            throw new DomainException(sprintf(
                '%s - Can not initialize the git repository in %s: %s'
                , __METHOD__, $path, implode("\n", $output)));

        $this->output(implode(NL, $output));

        $this->output('ok', true, 'green');

        return $this;
    }

	private function copyProjectFiles()
	{
		$path = $this->repoDir.'/'.$this->projectName;

		$folders = array('build', 'component', 'tests');

		foreach ($folders as $folder)
		{
			JFolder::copy($this->templatePath.'/project/'.$folder, $path.'/'.$folder);
		}

		$files = JFolder::files($path);

		foreach ($files as $file)
		{
			$contents = JFile::read($file);

			$contents = $this->replace($contents);

			JFile::write($file, $contents);
		}

		return $this;
	}

    private function setupJenkins()
    {
        $path = $this->jenkinsPath.'/jobs/'.$this->projectName;

        $this->output('Setting up Jenkins project in ', false, 'yellow')->output($path);

        if(false == JFolder::create($path))
            throw new DomainException(sprintf(
                '%s - Can not create the Jenkins dir in %s'
                , __METHOD__, $path
            ));

        $contents = JFile::read($this->templatePath.'/jenkins/config.xml');
        $contents = $this->replace($contents);

        JFile::write($path.'/config.xml', $contents);

        $this->output('ok', true, 'green');

        return $this;
    }

    private function replace($string)
    {
        $replacements = array(
            '{{REPO_DIR}}' => $this->repoDir.'/'.$this->projectName
        );

        foreach($replacements as $k => $v)
        {
            $string = str_replace($k, $v, $string);
        }

        return $string;
    }

    /**
     * Checks if a given folder exists, and if so, create a new name
     * using a subsequent with the postfix _<n>.
     *
     * @param string $checkPath The base path
     * @param string $folder The folder name
     * @param int $cnt
     *
     * @return string
     */
    private function checkAvailable($checkPath, $folder, $cnt = 0)
    {
        $f = $folder.($cnt ? '_'.$cnt : '');

        $path = $checkPath.'/'.$f;

        if(JFolder::exists($path))
            return $this->checkAvailable($checkPath, $folder, ++$cnt);

        return $f;
    }
}

/*
 * Main routine ----->
 */

try
{
    JApplicationCli::getInstance('JdlJenkinstemplate')->execute();
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
