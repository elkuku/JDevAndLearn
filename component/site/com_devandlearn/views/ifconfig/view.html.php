<?php defined('_JEXEC') || die('=;)');
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 27-Jun-2012
 * @license    GNU/GPL
 */

jimport('joomla.application.component.view');

/**
 * Ifconfig view.
 *
 * @package    DevAndLearn
 * @subpackage Views
 */
class DevAndLearnViewIfconfig extends JViewLegacy
{
    protected $ifconfigInfo = null;

    protected $path = '/sbin/ifconfig';

    /**
     * DevAndLearnList view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
        $this->ifconfigInfo = new stdClass;

        exec($this->path, $output);

        $this->ifconfigInfo->raw = implode("\n", $output);

        DalToolbarHelper::setup();

        parent::display($tpl);
    }
}
