<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/19/12
 * Time: 9:53 PM
 * To change this template use File | Settings | File Templates.
 */

class DalGitHelper
{
    private $basePath = '';

    public static function getInstance($basePath)
    {
        $basePath = realpath($basePath);

        return new DalGitHelper($basePath);
    }

    private function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function getRepos()
    {
        $repos = array();

        if(JFolder::exists($this->basePath.'/.git'))
        {
            $repos[] = $this->basePath;
        }
        else
        {
            foreach(JFolder::folders($this->basePath) as $folder)
            {
                $path = $this->basePath.'/'.$folder;

                if(false == JFolder::exists($path.'/.git'))
                    continue;

                $r = new DalRepo;

                $r->dir = $folder;
                $r->path = $path;

                $repos[] = $r;
            }
        }

        return $repos;
    }
}
