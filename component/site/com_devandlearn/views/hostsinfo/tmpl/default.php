<?php defined('_JEXEC') || die('=;)');
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 27-Jun-2012
 * @license    GNU/GPL
 */

echo DalToolbarHelper::display();

?>
<h1 class="DalHeader"><i class="icon-info-sign"></i> Hosts Info</h1>

<p><i class="icon-file"></i> <code> /etc/hosts</code></p>

<pre><?= $this->hostsInfo->raw ?></pre>

<br /><code>@todo: parse this ?</code>
