<?php
/**
 * This file is part of the twig-cli project.
 *
 * Copyright (c) 2018 Daniel Sigg (code[at]daniel-sigg[dot]de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 10.11.18
 * Time: 13:01.
 */

namespace DaSi\TwigCli\Compiler;

class Compiler
{
    public function compile($source, $template, $destination)
    {
        $loader = new \Twig_Loader_Filesystem($source);
        $twig = new \Twig_Environment($loader);

        $output = $this->getOutputFilename($destination, $template);

        file_put_contents($output, $twig->render($template));
    }

    private function getOutputFilename($destination, $template)
    {
        if (!('.twig' === \substr($template, -5, 5))) {
            throw new InvalidTemplateException(\sprintf("Template filenames must end with '.twig', '%s' given.", $template));
        }

        return $destination.\DIRECTORY_SEPARATOR.\substr($template, 0, -5);
    }
}
