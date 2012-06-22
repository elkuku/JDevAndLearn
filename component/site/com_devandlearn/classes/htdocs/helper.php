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

    private $rootUri = '';

    public function __construct($rootDir, $rootUri)
    {
        $path = realpath($rootDir);

        if(false == JFolder::exists($path))
            throw new DomainException('Http root path not found: '.$path);

        $this->rootDir = $path;

        $this->rootUri = $rootUri;
    }

    public function getDirectories()
    {
        $directories = array();

        /* @var DirectoryIterator $fInfo */
        foreach(new DirectoryIterator($this->rootDir) as $fInfo)
        {
            if(false == $fInfo->isDir() || $fInfo->isDot())
                continue;

            $directories[$fInfo->getBasename()] = new DalHtdocsDirectory($fInfo, $this->rootUri);
        }

        ksort($directories);

        return $directories;
    }
}
