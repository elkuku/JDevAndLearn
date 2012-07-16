# Environment Specifications

## Operating system

* [OpenSUSE OS](http://opensuse.org)

> **Why** ?<br />The build servers and facilities located at [susestudio.org](http://susestudio.org) are IOHO the only feasable way to **setup**, **distribute** <big>and</big> **maintain** a project like a customized operating system.

Last but not least, OpenSUSE is still the most amazing (main stream) Linux distro available - but that's another story...

## Server Software

* [XAMPP](http://www.apachefriends.org/de/xampp-linux.html) containing Apache, MySQL, PHP...

> **Why** (the hell) ?<br />This is also related to the way we build and distribute the package.<br />
Short: It makes things a lot easier if you have everything **in one place** (talking about config files, pear packages, etc).

If you feel uncomfortable, feel free to use OpenSUSEs package manager YAST to install the software you like.

### PEAR Packages

* PHP_CodeSniffer - Verifying coding standards.
* PHPUnit - Unit Tests.
* phpcpd - Copy&Paste Detector.
* PHP_Depend
* phploc - Lines of Code
* PHPMD - Mess Detector

## Build Server

* [Jenkins](http://jenkins-ci.org/)

> From their website, [meet Jenkins](https://wiki.jenkins-ci.org/display/JENKINS/Meet+Jenkins):<br />
> Jenkins is an application that monitors executions of repeated jobs, such as building a software project or jobs run by cron.

Jenkins has been set up to build PHP projects. A script is provided that automatically creates and set up new Jenkins jobs for your projects.

### Jenkins Plugins

*    Checkstyle (for processing PHP_CodeSniffer logfiles in Checkstyle format)
*    Clover PHP (for processing PHPUnit code coverage xml output)
*    DRY (for processing phpcpd logfiles in PMD-CPD format)
*    HTML Publisher (for publishing the PHPUnit code coverage report, for instance)
*    JDepend (for processing PHP_Depend logfiles in JDepend format)
*    Plot (for processing phploc CSV output)
*    PMD (for processing PHPMD logfiles in PMD format)
*    Violations (for processing various logfiles)
*    xUnit (for processing PHPUnit logfiles in JUnit format)

## Selenium

Selenium Server and Selenium IDE (for Firefox) and installed to create and run system tests.

* <http://seleniumhq.org>

## Utilities

* [Template for Jenkins Jobs for PHP Projects](http://jenkins-php.org/)

Which provides the template for Jenkins PHP jobs, and also a ```build.xml``` file ([download](http://jenkins-php.org/download/build.xml)) for Apache Ant.

## Other programs

### Mozilla Firefox

Some usefull Firefox addons that may help you while developing are included for your convenience.
