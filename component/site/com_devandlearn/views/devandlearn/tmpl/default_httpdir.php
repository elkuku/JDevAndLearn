<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 12:28 AM
 * To change this template use File | Settings | File Templates.
 */

?>
<h2 xmlns="http://www.w3.org/1999/html">Web Space</h2>
<p>
    <code>
        <i class="icon-folder-open"></i> <?= $this->httpDir ?>
    </code>
</p>

<p>
    <code>
        <i class="icon-globe"></i> <a href="<?= $this->httpUrl ?>"><?= $this->httpUrl ?></a>
    </code>
</p>

<hr />

<ul class="unstyled">
    <? foreach($this->httpList as $dir) : ?>
    <li>
        <? if($dir->isJoomla) : ?>
        <i class="iconJoomla"></i>
        <? endif; ?>

        <a class="httpLink" href="<?= $this->httpUrl.'/'.$dir->base ?>"><?= $dir->base ?></a>

        <? if($dir->isJoomla) : ?>
        &nbsp;
        <a href="<?= $this->httpUrl.'/'.$dir->base.'/administrator' ?>">
            Administrator
        </a>
        <? endif; ?>
    </li>
    <? endforeach; ?>
</ul>

<?php
//var_dump($this->httpList);
