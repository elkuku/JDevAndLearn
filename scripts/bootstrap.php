<?php defined('_JEXEC') || die('=;)');
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/29/12
 * Time: 2:01 AM
 * To change this template use File | Settings | File Templates.
 */

define('NL', "\n");

// Setup the base path related constant.
// This is one of the few, mandatory constants needed for the Joomla Platform.
define('JPATH_BASE', dirname(__FILE__));
define('JPATH_SITE', JPATH_BASE);

define('JDLPATH_CONFIG', __DIR__);

// Increase error reporting to that any errors are displayed.
// Note, you would not use these settings in production.
error_reporting(- 1);
ini_set('display_errors', true);

// Bootstrap the application.
require getenv('JOOMLA_PLATFORM_PATH').'/libraries/import.php';

require getenv('KUKU_JLIB_PATH').'/loader.php';

require JPATH_BASE.'/_classes/loader.php';
