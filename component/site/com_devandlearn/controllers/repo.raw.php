<?php
/**
 * @package    DevAndLearn
 * @subpackage Controllers
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 20-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


jimport('joomla.application.component.controller');

/**
 * Repo controller
 *
 * @package    DevAndLearn
 * @subpackage Controllers
 */
class DevAndLearnControllerRepo extends JController
{
    private $response = null;

    public function __construct($config = array())
    {
        $this->response = new stdClass;

        $this->response->status = 0;
        $this->response->text = '';

        parent::__construct($config);
    }

    public function getInfo()
    {
        $input = JFactory::getApplication()->input;

        $cfg = DalConfig::getConfig();

        $dir = $input->getPath('repo');
        $type = $input->get('type');

        $repoDir = realpath($cfg->global->repoDir.'/'.$dir);

        switch($type)
        {
            case 'status' :
                exec('cd "'.$repoDir.'" && git status -sb', $output, $ret);
                break;

            case 'remotes' :
                exec('cd "'.$repoDir.'" && git remote -v', $output, $ret);
                break;

            case 'branches' :
                exec('cd "'.$repoDir.'" && git branch', $output, $ret);
                break;

            case 'allbranches' :
                exec('cd "'.$repoDir.'" && git branch -a', $output, $ret);
                break;

            default :
                $output = array('Unknown type');
                $ret = 1;
        }

        $this->response->text = '<pre>'.implode("\n", $output).'</pre>';

        if(0 !== $ret)
        {
            $this->response->status = $ret;
        }

        echo json_encode($this->response);

        jexit();
    }
}
