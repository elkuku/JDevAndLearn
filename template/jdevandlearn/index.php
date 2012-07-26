<?php defined('_JEXEC') || die('=;)');
/**
 * @package    JDevAndLearn
 * @subpackage Base
 * @author     Nikolai Plath {@link https://github.com/elkuku}
 * @author     Created on 14-Jun-2012
 * @license    GNU/GPL
 */

//-- "Override the system message renderer
include 'classes/renderer/message.php';

$application = JFactory::getApplication();
$templateParams = $application->getTemplate(true)->params;
$baseLink = $this->baseurl.'/templates/'.$this->template;
$min = '';//(JDEBUG) ? '.min' : '';

echo '<?xml version="1.0" encoding="utf-8"?'.'>';
?>

<!DOCTYPE html>
<html lang="<?= $this->language ?>" dir="<?= $this->direction ?>">
    <head>
        <jdoc:include type="head" />
        <link rel="stylesheet" href="<?= $baseLink.'/css/bootstrap'.$min.'.css'; ?>" type="text/css" />
        <link rel="stylesheet" href="<?= $baseLink.'/css/icomoon.css'; ?>" type="text/css" />
        <link rel="stylesheet" href="<?= $baseLink.'/css/template'.$min.'.css'; ?>" type="text/css" />
    </head>
    <body>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar">a</span>
                    <span class="icon-bar">s</span>
                    <span class="icon-bar">d</span>
                </a>
                <a class="brand" href="#">
                    PHP
                    <i class="icon-lab"></i> DevBox
                </a>
                <div class="btn-group pull-right">
                    <a href="index.php/team" class="btn btn-admin"><i class="icon-user"></i> Team</a>
                    <a href="administrator" class="btn btn-admin"><i class="icon-key"></i> Admin</a>
                    <jdoc:include type="modules" name="position-4" />
                </div>
                <div class="nav-collapse">
                    <jdoc:include type="modules" name="position-1" />
                </div>
            </div>
            <div class="breadcrumbs">
                <jdoc:include type="modules" name="position-2" />
            </div>
        </div>
    </div>

    <jdoc:include type="message" />

    <div class="container">

        <jdoc:include type="component" />

        <hr>

        <footer>
            <jdoc:include type="modules" name="position-12"/>
            <p class="pull-right">Powered by <a href="http://joomla.org" class="icon-joomla-bw"> Joomla!</a></p>
            <p>
                <a href="https://github.com/PhpDevBox/PhpDevBox">
                PHP <i class="icon-lab"></i> DevBox Team 2012<?= (date('Y') != '2012')?' - '.date('Y'):''; ?> <i class="icon-creative-commons"></i>
                </a>
            </p>

        </footer>

    </div>

    </body>
</html>
