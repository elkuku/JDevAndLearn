<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 12:28 AM
 * To change this template use File | Settings | File Templates.
 */

/* @var DalHtdocsDirectory $dir */

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

<hr/>

<? foreach($this->httpList as $dir) : //var_dump($dir);?>
<div class="row">
    <div class="span2">
        <a class="httpLink <?= $dir->icon ?>" href="<?= $this->httpUrl.'/'.$dir->base ?>">
            <?= $dir->base ?>
        </a>
    </div>

    <div class="span2">
        <div class="btn-group pull-right">
            <? if($dir->symLinkerLink) : ?>
            <a class="btn btn-mini" href="<?= $dir->symLinkerLink ?>"
               title="Symlinks">
                <i class="icon-asterisk"></i>
            </a>
            <? endif; ?>

            <? if('joomlacms' == $dir->type) : ?>
            <a class="btn btn-mini" href="<?= $this->httpUrl.'/'.$dir->base.'/administrator' ?>"
               title="Administrator">
                Admin
            </a>
            <? endif; ?>
        </div>
    </div>
</div>
<? endforeach; ?>

<?php
