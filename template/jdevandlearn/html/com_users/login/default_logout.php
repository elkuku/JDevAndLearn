<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
?>
<div class="logout<?= $this->pageclass_sfx?>">
    <h1>Logout</h1>

    <form action="<?= JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post">
        <p>
            Really ? ...
            <button type="submit" class="btn btn-large btn-warning">
                <i class="icon-lock"></i> <?= JText::_('JLOGOUT'); ?>
            </button>
            <input type="hidden" name="return" value="<?= base64_encode($this->params->get('logout_redirect_url', $this->form->getValue('return'))); ?>" />
            <?= JHtml::_('form.token'); ?>
        </p>
    </form>
</div>
