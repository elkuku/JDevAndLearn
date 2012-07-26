<?php defined('_JEXEC') || die('=;)');
/**
 * @package    DevAndLearn
 * @subpackage Views
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 07-Jul-2012
 * @license    GNU/GPL
 */

echo DalToolbarHelper::display();

?>
<pre>
	<?php foreach($this->raw as $line) : ?>
    <?= $line."\n" ?>
    <?php endforeach; ?>
</pre>

<br/><code>@todo: parse this ?</code>
<br/><code>@todo: Add/Edit/Remove ?</code>
