<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/27/12
 * Time: 6:15 PM
 * To change this template use File | Settings | File Templates.
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');

$credentials = $this->form->getFieldset('credentials');

?>
<div class="login<?= $this->pageclass_sfx?>">

    <h1 class="login"><i class="icon-key"></i> Login</h1>

    <div class="row">

        <div class="span6">
            <form class="form-horizontal"
                  action="<?= JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
                <fieldset>

                    <div class="control-group">
                        <div class="input-prepend">
                            <span class="add-on" title="<?= $credentials['username']->title ?>"><i
                                class="icon-user"></i></span>
                            <?= $credentials['username']->input ?>
                        </div>
                    </div>

                    <div class="control-group">

                        <div class="input-prepend">
                            <span class="add-on" title="<?= $credentials['password']->title ?>"><i
                                class="icon-key"></i></span>
                            <?= $credentials['password']->input ?>
                        </div>
                    </div>

                    <?php if(0): //JPluginHelper::isEnabled('system', 'remember')) : ?>
                    <div class="login-fields control-group">
                        <div class="input-prepend">
                    <span class="add-on">@
                        </span>
                            <!--
                    <label id="remember-lbl" class="control-label"
                           for="remember"><?//= JText::_('JGLOBAL_REMEMBER_ME') ?></label>
                           -->
                            <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"
                                   alt="<?= JText::_('JGLOBAL_REMEMBER_ME') ?>"
                                   title="<?= JText::_('JGLOBAL_REMEMBER_ME') ?>"/>
                        </div>
                    </div>
                    <?php endif; ?>
                    <p>
                        <button type="submit"
                                class="btn btn-success btn-large">
                            <i class="icon-locked"></i> <?= JText::_('JLOGIN'); ?>
                        </button>
                    </p>
                    <input type="hidden" name="return"
                           value="<?= base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))) ?>"/>
                    <?= JHtml::_('form.token') ?>
                </fieldset>
            </form>
        </div>

        <div class="span6">
            <ul class="unstyled">
                <li>
                    <a href="<?= JRoute::_('index.php?option=com_users&view=remind'); ?>">
                        <i class="icon-user"></i>
                        <?= JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
                </li>
                <li>
                    <a href="<?= JRoute::_('index.php?option=com_users&view=reset'); ?>">
                        <i class="icon-key"></i>
                        <?= JText::_('COM_USERS_LOGIN_RESET'); ?></a>
                </li>
                <?php
                $usersConfig = JComponentHelper::getParams('com_users');
                if($usersConfig->get('allowUserRegistration')) : ?>
                    <li>
                        <a href="<?= JRoute::_('index.php?option=com_users&view=registration'); ?>">
                            <i class="icon-pencil"></i>
                            <?= JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
                    </li>
                    <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
