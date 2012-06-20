<?php defined('_JEXEC') || die('=;)');
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 16-Jun-2012
 * @license    GNU/GPL
 */

JHtml::stylesheet('media/com_devandlearn/site/css/devandlearn.css');

echo DalToolbarHelper::display();
?>

<h1 class="DalHeader">PHP Info</h1>

<?php echo DalConfigPhp::getPHPInfo();
