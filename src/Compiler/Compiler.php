<?php
/**
 * This file is part of the twig-cli project.
 *
 * Copyright (c) 2018 Daniel Sigg (code[at]daniel-sigg[dot]de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *
 */

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 10.11.18
 * Time: 13:01
 */

namespace DaSi\TwigCli\Compiler;


class Compiler
{
    public function compileTask($task)
    {
        $loader = new \Twig_Loader_Filesystem(task['source']);
        $twig = new \Twig_Environment($loader);

        echo $twig->render(task['template']);
    }
}