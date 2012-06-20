<?php
/**
 * @package    DevAndLearn
 * @subpackage Models
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 20-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


jimport('joomla.application.component.model');

/**
 * Devandlearn model.
 *
 * @package    DevAndLearn
 * @subpackage Models
 */
class DevAndLearnModelDevandlearn extends JModel
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Additional work
        $foo = 'Bar';

        parent::__construct();
    }//function

    public function getHttplist()
    {
        return array('fooooooo');
    }
}//class
