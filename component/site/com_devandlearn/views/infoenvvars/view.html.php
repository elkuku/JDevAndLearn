<?php
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 27-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


jimport('joomla.application.component.view');

/**
 * Infoenvvars view.
 *
 * @package    DevAndLearn
 * @subpackage Views
 */
class DevAndLearnViewInfoenvvars extends JView
{
    protected $infoEnvvars = null;

    protected $path = '';

    /**
     * DevAndLearnList view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
        $this->infoEnvvars = new stdClass;

        $user = exec('echo $JDL_USER');

        $this->path = '/etc/profile.local';

        $this->infoEnvvars->raw = JFile::read($this->path);

        DalToolbarHelper::setup();

        parent::display($tpl);
    }//function
}//class
