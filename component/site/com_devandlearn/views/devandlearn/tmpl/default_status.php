<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 12:28 AM
 * To change this template use File | Settings | File Templates.
 */

?>
<h2><i class="icon-wrench"></i> Status</h2>

<?php foreach($this->services as $service) : ?>
<div class="row">
    <div class="span2"><h4><?= $service->name ?></h4></div>
    <div class="span1">
        <?php if($service->isUp) : ?>
        <span class="badge badge-success">Running</span>
        <?php else : ?>
        <span class="badge">Idle</span>
        <?php endif; ?>
    </div>
    <div class="span1">
        <?= DalToolbarButton::getInstance(array('icon' => 'icon-refresh'))->render(); ?>
    </div>
</div>
    <?php if($service->links) : ?>
        <ul>
        <?php foreach($service->links as $text => $href) : ?>
            <li>
                <a href="<?= $href ?>"><?= $text ?></a>
            </li>
            <?php endforeach ?>
        </ul>
        <?php endif; ?>
    <hr />
<?php endforeach;
