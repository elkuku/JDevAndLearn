<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/20/12
 * Time: 12:56 AM
 * To change this template use File | Settings | File Templates.
 */

class DalHtdocsHelper
{
    private $rootDir = '';

    public function __construct($rootDir)
    {
        $path = realpath($rootDir);

        if(false == JFolder::exists($path))
            throw new DomainException('Http root path not found: '.$path);

        $this->rootDir = $path;
    }

    public function getDirectories()
    {
        $directories = array();

        /* @var DirectoryIterator $fInfo */
        foreach(new DirectoryIterator($this->rootDir) as $fInfo)
        {
            if(false == $fInfo->isDir() || $fInfo->isDot())
                continue;

            $d = new stdClass;
            $d->path = $fInfo->getPath();
            $d->base =$fInfo->getBasename();
            $d->path = $fInfo->getPathname();

            $d->isJoomla = JFolder::exists($fInfo->getPathname().'/administrator')
                && JFile::exists($fInfo->getPathname().'/configuration.php');

            $directories[$d->base] = $d;
        }

        ksort($directories);

        return $directories;
    }
}
