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
<h2><i class="icon-globe"></i> Web Space</h2>
<p>
    <i class="icon-folder"></i> <code><?= $this->httpDir ?></code>
</p>

<p>
    <i class="icon-globe"></i> <code><a href="<?= $this->httpUrl ?>"><?= $this->httpUrl ?></a></code>
</p>

<hr/>

<? foreach($this->httpList as $dir) : /* @var DalHtdocsDirectory $dir */ ?>
<div class="row">
    <div class="span3">
        <a target="_blank" class="httpLink <?= $dir->icon ?>" href="<?= $this->httpUrl.'/'.$dir->base ?>">
            <?= $dir->base ?>
        </a>
    </div>

    <div class="span1">
        <div class="btn-group pull-right">
            <? if($dir->symLinkerLink) : ?>
            <a target="_blank" href="<?= $dir->symLinkerLink ?>"
               title="Symlinks">
                <i class="icon-star"></i>
            </a>
            <? endif; ?>

            <? if($dir->isSqlite) : ?>
            <a target="_blank" href="<?= $dir->linkAdminer ?>"
               title="Adminer DB admin">
                <i class="icon-database"></i>
            </a>
            <? endif; ?>

            <? if('joomlacms' == $dir->type) : ?>
            <a target="_blank" href="<?= $this->httpUrl.'/'.$dir->base.'/administrator' ?>"
               title="Administrator">
                <i class="icon-key"></i>
            </a>
            <? endif; ?>
        </div>
    </div>
</div>
<? endforeach; ?>

<?php
