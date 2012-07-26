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
 * infolocalconf view.
 *
 * @package    DevAndLearn
 * @subpackage Views
 */
class DevAndLearnViewinfolocalconf extends JViewLegacy
{
    protected $infoLocalconf = null;

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
        $this->infoLocalconf = new stdClass;

        $user = exec('whoami');

        $this->path = '/home/'.$user.'/srv/conf/local.conf';

        $this->infoLocalconf->raw = JFile::read($this->path);

        DalToolbarHelper::setup();

        parent::display($tpl);
    }
}
