<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/19/12
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */

class DalToolbarHelper
{
    protected static $buttonGroups = array();

    public static function addButton(DalToolbarButton $button, $group = '')
    {
        $group = $group ?: 'default';

        if(false == isset(self::$buttonGroups[$group]))
            self::$buttonGroups[$group] = array();

        self::$buttonGroups[$group][] = $button;
    }

    public static function display($class = '')
    {
        $html = '';

        $html[] = '<div class="btn-toolbar '.$class.'">';

        foreach(self::$buttonGroups as $group => $buttons)
        {
            $html[] = '<div class="btn-group '.$group.'">';

            /* @var DalToolbarButton $button */
            foreach($buttons as $button)
            {
                $html = array_merge($html, $button->render(true));
            }

            $html[] = '</div>';
        }

        $html[] = '</div>';

        return implode("\n", $html);
    }

    public static function setup()
    {
        $input = JFactory::getApplication()->input;

        self::addButton(new DalToolbarButton(array(
            'href' => JRoute::_('&view=&task='),
            'icon' => 'icon-dashboard',
            'text' => 'Dashboard',//jgettext..
            'class' => $input->get('view', 'devandlearn') == 'devandlearn' ? 'active' : ''
        )), 'actions');

        self::addButton(new DalToolbarButton(array(
            'href' => JRoute::_('&view=phpinfo&task='),
            'icon' => 'icon-info-sign',
            'text' => 'PHP Info',//jgettext..
            'class' => $input->get('view') == 'phpinfo' ? 'active' : ''
        )), 'actions');

        self::addButton(new DalToolbarButton(array(
            'href' => JRoute::_('&view=gitinfo&task='),
            'icon' => 'icon-info-sign',
            'text' => 'Git Info',//jgettext..
            'class' => $input->get('view') == 'gitinfo' ? 'active' : ''
        )), 'actions');

        self::addButton(new DalToolbarButton(array(
            'href' => JRoute::_('&view=infolocalconf&task='),
            'icon' => 'icon-info-sign',
            'text' => 'Local config Info',//jgettext..
            'class' => $input->get('view') == 'infolocalconf' ? 'active' : ''
        )), 'actions');

        self::addButton(new DalToolbarButton(array(
            'href' => JRoute::_('&view=hostsinfo&task='),
            'icon' => 'icon-info-sign',
            'text' => 'Hosts Info',//jgettext..
            'class' => $input->get('view') == 'hostsinfo' ? 'active' : ''
        )), 'actions');

        self::addButton(new DalToolbarButton(array(
            'href' => JRoute::_('&view=infoenvvars&task='),
            'icon' => 'icon-info-sign',
            'text' => 'Environment vars',//jgettext..
            'class' => $input->get('view') == 'infoenvvars' ? 'active' : ''
        )), 'actions');

        self::addButton(new DalToolbarButton(array(
            'href' => JRoute::_('&view=ifconfig&task='),
            'icon' => 'icon-info-sign',
            'text' => 'Ifconfig Info',//jgettext..
            'class' => $input->get('view') == 'ifconfig' ? 'active' : ''
        )), 'actions');
    }
}
