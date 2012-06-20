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

JHtml::stylesheet('media/com_devandlearn/site/css/devandlearn.css');
JHtml::script('media/com_devandlearn/site/js/gitrepo.js');

JHtml::_('behavior.mootools');


echo DalToolbarHelper::display();
?>

<h1 class="DalHeader">Dashboard</h1>

    <div class="row">
        <div class="span4">
            <?= $this->loadTemplate('httpdir'); ?>
        </div>
        <div class="span4">
            <div class="well">
                <?= $this->loadTemplate('repodir'); ?>
            </div>
        </div>
        <div class="span4">
            <?= $this->loadTemplate('status'); ?>
        </div>
    </div>
