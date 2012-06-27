<?php defined('_JEXEC') || die('=;)');
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 16-Jun-2012
 * @license    GNU/GPL
 */

echo DalToolbarHelper::display();
?>

<h1 class="DalHeader"><i class="icon-info-sign"></i> PHP Info</h1>

<?= DalConfigPhp::getInfo();
