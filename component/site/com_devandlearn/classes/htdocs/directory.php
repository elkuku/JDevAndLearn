<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/21/12
 * Time: 11:34 PM
 * To change this template use File | Settings | File Templates.
 */

class DalHtdocsDirectory
{
    public $base = '';

    public $baseUri = '';

    public $path = '';

    public $type = '';

    public $title = '';

    public $icon = '';

    public $symLinkerLink = '';

    public function __construct(DirectoryIterator $dirInfo, $rootUri)
    {
        //$this->path = $fInfo->getPath();
        $this->base = $dirInfo->getBasename();

        $this->path = $dirInfo->getPathname();

        $this->baseUri = $rootUri.'/'.$this->base;

        $this->symLinkerLink = (file_exists($this->path.'/symlinker.php'))
            ? $this->baseUri.'/symlinker.php' : '';

        if(JFolder::exists($this->path.'/administrator')
            && JFile::exists($this->path.'/configuration.php')
        )
        {
            $this->type = 'joomlacms';
            $this->title = 'Joomla! CMS';
            $this->icon = 'iconJoomla';
        }

    }
}
