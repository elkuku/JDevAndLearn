<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Document
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * JDocument system message renderer
 *
 * @package     Joomla.Platform
 * @subpackage  Document
 * @since       11.1
 */
class JDocumentRendererMessage extends JDocumentRenderer
{
    /**
     * Renders the error stack and returns the results as a string
     *
     * @param   string  $name     Not used.
     * @param   array   $params   Associative array of values
     * @param   string  $content  Not used.
     *
     * @return  string  The output of the script
     *
     * @since   11.1
     */
    public function render($name, $params = array (), $content = null)
    {
        // Initialise variables.
        $buffer = array();
        $lists = array();

        $icons = array(
            'error' => 'exclamation-sign',
            'warning' => 'question-sign',
            'info' => 'info-sign',
            'success' => 'ok',
        );

        // Get the message queue
        $messages = JFactory::getApplication()->getMessageQueue();

        // Build the sorted message list
        if (false == is_array($messages) || empty($messages))
            return '';

        foreach ($messages as $msg)
        {
            $lists[$msg['type']][] = $msg['message'];
        }

        foreach ($lists as $type => $msgs)
        {
            if (0 ==count($msgs))
                continue;

            //-- compatibility..
            if('message' == $type) $type = 'info';
            $icon = (isset($icons[$type])) ? $icons[$type] : 'question-sign';

            $buffer[] = '<div class="systemMessage alert alert-'.$type.'">';
            $buffer[] = '<i class="messageIcon icon-'.$icon.'"></i>';
            $buffer[] = '   <ul class="unstyled">';

            foreach ($msgs as $msg)
            {
                $buffer[] = '      <li>'. $msg . '</li>';
            }

            $buffer[] = '   </ul>';
            $buffer[] = '</div>';
        }

        return implode("\n", $buffer);
    }
}
