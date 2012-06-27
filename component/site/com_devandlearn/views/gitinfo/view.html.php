<?php
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 22-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


jimport('joomla.application.component.view');

/**
 * GitInfo view.
 *
 * @package    DevAndLearn
 * @subpackage Views
 */
class DevAndLearnViewGitInfo extends JView
{
    protected $gitInfo = array();

    /**
     * DevAndLearnList view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return mixed|void
     */
    public function display($tpl = null)
    {
        DalToolbarHelper::setup();

        $this->gitInfo = DalConfigGit::getInfo('/home/'.getenv('JDL_USER'));

        parent::display($tpl);
    }
}
