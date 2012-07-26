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
 * HostsInfo view.
 *
 * @package    DevAndLearn
 * @subpackage Views
 */
class DevAndLearnViewHostsInfo extends JViewLegacy
{
    protected $hostsInfo = null;

    /**
     * DevAndLearnList view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
        $this->hostsInfo = new stdClass;

        $this->hostsInfo->raw = JFile::read('/etc/hosts');

        DalToolbarHelper::setup();

        parent::display($tpl);
    }
}
