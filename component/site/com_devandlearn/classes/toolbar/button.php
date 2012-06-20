<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/19/12
 * Time: 6:59 PM
 * To change this template use File | Settings | File Templates.
 */

class DalToolbarButton
{
    /**
     * @var JRegistry
     */
    private $attribs = null;

    public static function getInstance(array $attribs)
    {
        return new DalToolbarButton($attribs);
    }

    public function __construct(array $attribs)
    {
        $this->attribs = new JRegistry($attribs);
    }

    public function render($asArray = false)
    {
        $html = array();

        $class = 'btn '.$this->attribs->get('class');
        $href = $this->attribs->get('href') ?: 'javascript:void(0);';
        $onclick = $this->attribs->get('onclick') ? ' onclick="'.$this->attribs->get('onclick').'"': '';
        $icon = $this->attribs->get('icon') ?: '';
        $text = $this->attribs->get('text') ?: '';

        $title = $this->attribs->get('title') ? ' title="'.$this->attribs->get('title').'"': '';

        $html[] = '<a class="'.$class.'" href="'.$href.'"'.$title.$onclick.'>';

        if($icon) $html[] = '    <i class="'.$icon.'"></i>';
        if($text) $html[] = '   '.$text;

        $html[] = '</a>';

        return ($asArray) ? $html : implode("\n", $html);
    }
}
