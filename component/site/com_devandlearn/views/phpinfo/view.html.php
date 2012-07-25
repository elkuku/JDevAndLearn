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

jimport('joomla.application.component.view');

/**
 * phpinfo view.
 *
 * @package    DevAndLearn
 * @subpackage Views
 */
class DevAndLearnViewPhpinfo extends JViewLegacy
{
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

        parent::display($tpl);
    }
}
