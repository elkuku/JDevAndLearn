<?php defined('_JEXEC') || die('=;)');
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 07-Jul-2012
 * @license    GNU/GPL
 */

jimport('joomla.application.component.view');

/**
 * Pear view.
 *
 * @package    DevAndLearn
 * @subpackage Views
 */
class DevAndLearnViewPear extends JViewLegacy
{
	/**
	 * DevAndLearnList view display method.
	 *
	 * @param string $tpl The name of the template file to parse;
	 *
	 * @return void
	 */
	public function display($tpl = null)
	{
		DalToolbarHelper::setup();

		exec('pear list -a 2>&1', $output);

		$this->raw = $output;

		parent::display($tpl);
	}
}
