<?php
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 16-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

//-- Import the JView class
jimport('joomla.application.component.view');

/**
 * HTML View class for the DevAndLearn Component.
 *
 * @package DevAndLearn
 */
class DevAndLearnViewDevAndLearn extends JView
{
    /**
     * @var SimpleXMLElement
     */
    private $configXml = null;

    protected $repoDir = '';

    protected $repoList = array();

    protected $httpDir = '';

    protected $httpUrl = '';

    protected $httpList = array();

    protected $services = array();

    /**
     * DevAndLearn view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @throws DomainException
     * @return mixed|void
     */
    public function display($tpl = null)
    {
        /*
        $params = JComponentHelper::getParams('com_devandlearn');

        $path = $params->get('configPath').'/config.xml';

        if(false == file_exists($path))
            throw new DomainException('ERROR: Config file not found at:'.$path);

        $this->configXml = simplexml_load_file($path);

        if(false == $this->configXml)
            throw new DomainException('ERROR: Invalid config at:'.$path);
*/
        $this->configXml = DalConfig::getConfig();

        $this->repoDir = $this->configXml->global->repoDir;

        $helper = DalGitHelper::getInstance($this->repoDir);

        $this->repoList = $helper->getRepos();

        $this->httpDir = $this->configXml->global->httpDir;

        $this->httpUrl = $this->configXml->global->httpDir->attributes()->url;

        $htdocsHelper = new DalHtdocsHelper($this->httpDir, $this->httpUrl);

        $this->httpList = $htdocsHelper->getDirectories();

        $this->services[] = new DalService('Jenkins', 'http://localhost:8080'
            , array('Jenkins Dashboard' => 'http://localhost:8080'));
        $this->services[] = new DalService('Mysql', 'service://mysql'
            , array('PHPMy Admin' => 'http://dev.local/phpmyadmin/'));
        $this->services[] = new DalService('ProFTP', 'service://proftpd');

        $js = array();

        foreach($this->services as $service)
        {
           // $js[] = "DalService.check('{$service->url}')";
        }

        JFactory::getDocument()->addScriptDeclaration(implode("\n", $js));
        DalToolbarHelper::setup();

        parent::display($tpl);
    }
}
