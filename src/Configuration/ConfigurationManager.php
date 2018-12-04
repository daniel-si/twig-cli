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
 * Time: 12:11.
 */

namespace DaSi\TwigCli\Configuration;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class ConfigurationManager
{
    private $config = null;

    public function loadConfiguration($filename)
    {
        $config = Yaml::parse(file_get_contents($filename));

        $processor = new Processor();
        $this->config = $processor->processConfiguration(new TaskConfiguration(), array($config));
    }

    public function getTasks()
    {
        if (null === $this->config) {
            throw new ConfigurationNotLoadedException();
        }

        return $this->config['tasks'];
    }
}
