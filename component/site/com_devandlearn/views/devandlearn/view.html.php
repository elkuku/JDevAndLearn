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
class DevAndLearnViewDevAndLearn extends JViewLegacy
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
        $this->configXml = DalConfig::getConfig();

        $this->repoDir = $this->configXml->global->repoDir;

        $helper = DalGitHelper::getInstance($this->repoDir);

        $this->repoList = $helper->getRepos();

        $this->httpDir = $this->configXml->global->httpDir;

        $this->httpUrl = $this->configXml->global->httpDir->attributes()->url;

        $htdocsHelper = new DalHtdocsHelper($this->httpDir, $this->httpUrl);

        $this->httpList = $htdocsHelper->getDirectories();

        $this->services[] = new DalService('Apache', 'service://apache');

        $this->services[] = new DalService('Mysql', 'service://mysql'
            , array('phpMyAdmin' => 'http://dev.local/phpmyadmin/'));

        $this->services[] = new DalService('PostgreSql', 'service://pgsql'
            , array('phpPgAdmin' => 'http://pgadmin.local/'));

        $this->services[] = new DalService('ProFTP', 'service://proftpd');

        $this->services[] = new DalService('Jenkins', 'http://localhost:8080'
            , array(
                'Jenkins Dashboard' => 'http://localhost:8080',
                'Shutdown' => 'http://localhost:8080/exit'));

        $this->services[] = new DalService('Selenium', 'http://localhost:4444', array(), 403);

        DalToolbarHelper::setup();

        parent::display($tpl);
    }
}
