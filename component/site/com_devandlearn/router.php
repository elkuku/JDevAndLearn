<?php
/**
 * @package    JDevAndLearn
 * @subpackage Base
 * @author     Nikolai Plath (elkuku)
 * @author     Created on 20-Jul-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

function DevAndLearnBuildRoute(&$query)
{
    $segments = array();

    if(isset($query['page']))
    {
        $segments[] = $query['page'];

        unset($query['page']);
    }

    return $segments;
}

function DevAndLearnParseRoute($segments)
{
    $vars = array();

    if(count($segments))
        $vars['page'] = implode('/', $segments);

    return $vars;
}
