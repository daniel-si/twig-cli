<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 28.11.18
 * Time: 07:36
 */

namespace DaSi\TwigCli\Container;


use DaSi\TwigCli\Compiler\Compiler;

class Container
{
    private $singletons;

    public function __construct()
    {
        $this->singletons = array();
    }

    public function getCompiler()
    {
        if (!isset($this->singletons['compiler'])) {
            $this->singletons['compiler'] = new Compiler();
        }

        return $this->singletons['compiler'];
    }


}