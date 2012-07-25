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
class DevAndLearnViewGitInfo extends JViewLegacy
{
    protected $gitInfo = array();

	protected $user = '';

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

	    $this->user = exec('whoami');

        $this->gitInfo = DalConfigGit::getInfo('/home/'.$this->user);

        parent::display($tpl);
    }
}
