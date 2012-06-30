<?php defined('_JEXEC') || die('=;)');
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 16-Jun-2012
 * @license    GNU/GPL
 */

JHtml::script('media/com_devandlearn/site/js/gitrepo.js');
JHtml::script('media/com_devandlearn/site/js/service.js');

JHtml::_('behavior.mootools');

echo DalToolbarHelper::display();
?>

<div class="row">
    <div class="span4">
        <?= $this->loadTemplate('httpdir'); ?>
    </div>
    <div class="span4">
        <div class="well repoDir">
            <?= $this->loadTemplate('repodir'); ?>
        </div>
    </div>
    <div class="span4">
        <?= $this->loadTemplate('status'); ?>
    </div>
</div>
