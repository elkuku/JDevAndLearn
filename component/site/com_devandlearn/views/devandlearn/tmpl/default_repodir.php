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

<h3><?= $repo->dir ?></h3>

<div class="btn-group pull-right">
        <?= DalToolbarButton::getInstance(array(
        'icon' => 'icon-check',
        'onclick' => "DalGitRepo.getInfo('status', '{$repo->dir}', this);",
        'title' => 'Status',
        'class' => 'btn-mini'
        ))->render(); ?>
        <?= DalToolbarButton::getInstance(array(
        'icon' => 'icon-globe',
        'onclick' => "DalGitRepo.getInfo('remotes', '{$repo->dir}', this);",
        'title' => 'Remotes',
        'class' => 'btn-mini'
        ))->render(); ?>
        <?= DalToolbarButton::getInstance(array(
        'icon' => 'icon-random',
        'onclick' => "DalGitRepo.getInfo('branches', '{$repo->dir}', this);",
        'title' => 'Branches',
        'class' => 'btn-mini'
        ))->render(); ?>
        <?= DalToolbarButton::getInstance(array(
        'icon' => 'icon-retweet',
        'onclick' => "DalGitRepo.getInfo('allbranches', '{$repo->dir}', this);",
        'title' => 'All Branches',
        'class' => 'btn-mini'
        ))->render(); ?>
</div>

    <div></div>
<div class="clearfix"></div>
<? endforeach; ?>

<?
//var_dump($this->repoList);

?>
