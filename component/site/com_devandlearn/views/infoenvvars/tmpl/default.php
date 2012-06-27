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
<h1 class="DalHeader"><i class="icon-info-sign"></i> Global Environment Variables</h1>

<p><i class="icon-file"></i> <code> <?= $this->path ?></code></p>

<pre><?= htmlentities($this->infoEnvvars->raw) ?></pre>

<br /><code>@todo: parse this ?</code>
