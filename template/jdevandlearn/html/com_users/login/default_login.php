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
//var_dump($credentials['username']);

?>
<div class="login<?php echo $this->pageclass_sfx?>">
    <h1>Login</h1>

    <div class="row">

        <div class="span6">

            <form class="form-horizontal"
                  action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
                <fieldset>
                    <div class="control-group">
                        <div class="input-prepend">
                            <span class="add-on" title="<?php echo $credentials['username']->title; ?>"><i
                                class="icon-user"></i></span>
                            <?= $credentials['username']->input ?>
                        </div>
                    </div>
                    <div class="control-group">

                        <div class="input-prepend">
                            <span class="add-on" title="$credentials['password']->title"><i
                                class="icon-lock"></i></span>
                            <?= $credentials['password']->input ?>
                        </div>
                    </div>

                    <?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
                    <div class="login-fields control-group">
                        <div class="input-prepend">
                    <span class="add-on">@
                        </span>
                            <!--
                    <label id="remember-lbl" class="control-label"
                           for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
                           -->
                            <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"
                                   alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>"
                                   title="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>"/>
                        </div>
                    </div>
                    <?php endif; ?>
                    <p>
                        <button type="submit"
                                class="btn btn-success btn-large">
                            <i class="icon-lock"></i> <?php echo JText::_('JLOGIN'); ?>
                        </button>
                    </p>
                    <input type="hidden" name="return"
                           value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>"/>
                    <?php echo JHtml::_('form.token'); ?>
                </fieldset>
            </form>
        </div>

        <div class="span6">
            <ul class="unstyled">
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
                        <i class="icon-lock"></i>
                        <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
                </li>
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
                        <i class="icon-user"></i>
                        <?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
                </li>
                <?php
                $usersConfig = JComponentHelper::getParams('com_users');
                if($usersConfig->get('allowUserRegistration')) : ?>
                    <li>
                        <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
                            <i class="icon-edit"></i>
                            <?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
                    </li>
                    <?php endif; ?>
            </ul>
        </div>

    </div>
</div>
