<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 12:28 AM
 * To change this template use File | Settings | File Templates.
 */

/* @var DalService $service */
?>
<h2><i class="icon-cog"></i> Status</h2>

<?php foreach($this->services as $service) : ?>
<div class="row">
    <div class="span3">
        <h4 data-icon="<?= $service->dataIcon ?>"> <?= $service->name ?></h4>
    </div>
    <div class="span1">
        <span class="badge badge-<?= $service->cssClass ?>"><?= $service->label ?></span>
    </div>
    <!--
    <div class="span1">
        <? //= DalToolbarButton::getInstance(array('icon' => 'icon-refresh'))->render(); ?>
    </div>
    -->
</div>
<?php if($service->links) : ?>
    <ul class="unstyled">
        <?php foreach($service->links as $text => $href) : ?>
        <li>
            <a href="<?= $href ?>"><?= $text ?></a>
        </li>
        <?php endforeach ?>
    </ul>
    <?php endif; ?>
<hr/>
<?php endforeach; ?>
<a href="http://dev.local/adminer-3.4.0.php">
    <i class="icon-database"></i> Adminer
</a>
