<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 12:28 AM
 * To change this template use File | Settings | File Templates.
 */

?>
<h2>Repositories</h2>

<code><i class="icon-folder-open"></i> <?= $this->repoDir ?></code>

<hr />

<? foreach($this->repoList as $repo) : ?>

<div class="btn-group pull-right">
        <?= DalToolbarButton::getInstance(array(
        'icon' => 'icon-check',
        'onclick' => "DalGitRepo.getInfo('status', '{$repo->dir}');",
        'title' => 'Status',
        'class' => 'btn-mini'
        ))->render(); ?>
        <?= DalToolbarButton::getInstance(array(
        'icon' => 'icon-globe',
        'onclick' => "DalGitRepo.getInfo('remotes', '{$repo->dir}');",
        'title' => 'Remotes',
        'class' => 'btn-mini'
        ))->render(); ?>
        <?= DalToolbarButton::getInstance(array(
        'icon' => 'icon-random',
        'onclick' => "DalGitRepo.getInfo('branches', '{$repo->dir}');",
        'title' => 'Branches',
        'class' => 'btn-mini'
        ))->render(); ?>
        <?= DalToolbarButton::getInstance(array(
        'icon' => 'icon-retweet',
        'onclick' => "DalGitRepo.getInfo('allbranches', '{$repo->dir}');",
        'title' => 'All Branches',
        'class' => 'btn-mini'
        ))->render(); ?>
</div>
<h3><?= $repo->dir ?></h3>

<div id="repo_<?= $repo->dir ?>"></div>
<div class="clearfix"></div>
<? endforeach;
