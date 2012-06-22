<?php
/**
 * @package    DevAndLearn
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 16-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

//-- @debug flag
define('DAL_DEBUG', 1);

JLoader::registerPrefix('Dal', JPATH_COMPONENT_SITE.'/classes');

//-- Import the class JController
jimport('joomla.application.component.controller');

//-- Get an instance of the controller with the prefix 'DevAndLearn'
$controller = JController::getInstance('DevAndLearn');

//-- Execute the 'task' from the Request
$controller->execute(JFactory::getApplication()->input->get('task'));

//-- Redirect if set by the controller
$controller->redirect();
