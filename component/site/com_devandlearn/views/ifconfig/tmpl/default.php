<?php
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 27-Jun-2012
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

echo DalToolbarHelper::display();

?>
<p><i class="icon-file"></i> <code> /sbin/ifconfig</code></p>

<pre><?= $this->ifconfigInfo->raw ?></pre>

<br /><code>@todo: parse this ?</code>
