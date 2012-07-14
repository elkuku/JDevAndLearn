<?php defined('_JEXEC') || die('=;)');
/**
 * @package    JDevAndLearn
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 16-Jun-2012
 * @license    GNU/GPL
 */

define('NL', "\n");

// Setup the base path related constants.
define('JPATH_BASE', __DIR__);
define('JPATH_SITE', __DIR__);

// Joomla BS....
$_SERVER['HTTP_HOST'] = '';

define('JDLPATH_CONFIG', __DIR__);

// Increase error reporting to that any errors are displayed.
error_reporting(- 1);

ini_set('display_errors', true);

// Bootstrap the application.
require getenv('JOOMLA_PLATFORM_PATH').'/libraries/import.php';

// Bootstrap KuKu's libs.
require getenv('KUKU_JLIB_PATH').'/loader.php';

// Base autoloader.
require JPATH_BASE.'/_classes/loader.php';

require 'elkuku/g11n/language.php';

if(false == class_exists('JUri'))
{
	class JUri
	{
		public static function root()
		{
			return '';
		}
	}
}
