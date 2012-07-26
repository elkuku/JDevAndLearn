<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 12:28 AM
 * To change this template use File | Settings | File Templates.
 */

?>
<h2><i class="icon-github"></i> Repositories</h2>

<i class="icon-folder"></i> <code><?= $this->repoDir ?></code>

<hr/>

<? foreach($this->repoList as $repo) : ?>

<div class="btn-group pull-right" id="btns-<?= $repo->dir ?>">
    <?= DalToolbarButton::getInstance(array(
    'icon' => 'icon-checkmark',
    'onmousedown' => "DalGitRepo.getInfo('status', '{$repo->dir}', this);",
    'title' => 'Status',
    'class' => 'btn-mini'
))->render(); ?>

    <?= DalToolbarButton::getInstance(array(
    'icon' => 'icon-globe',
    'onmousedown' => "DalGitRepo.getInfo('remotes', '{$repo->dir}', this);",
    'title' => 'Remotes',
    'class' => 'btn-mini'
))->render(); ?>

    <?= DalToolbarButton::getInstance(array(
    'icon' => 'icon-share',
    'onmousedown' => "DalGitRepo.getInfo('branches', '{$repo->dir}', this);",
    'title' => 'Branches',
    'class' => 'btn-mini'
))->render(); ?>

    <?= DalToolbarButton::getInstance(array(
    'icon' => 'icon-share',
    'onmousedown' => "DalGitRepo.getInfo('allbranches', '{$repo->dir}', this);",
    'title' => 'All Branches',
    'class' => 'btn-mini'
))->render(); ?>
</div>

<h4><?= $repo->dir ?></h4>

<div id="repo_<?= $repo->dir ?>"></div>

<div class="clearfix"></div>

<? endforeach;
