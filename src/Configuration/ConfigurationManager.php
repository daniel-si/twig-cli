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
    private $tasks = null;

    public function loadConfiguration($filename)
    {
        $config = Yaml::parse(file_get_contents($filename));

        $processor = new Processor();
        $config = $processor->processConfiguration(new TaskConfiguration(), array($config));
        $this->tasks = $this->loadTasks($config);
    }

    /**
     * @return mixed
     *
     * @throws ConfigurationNotLoadedException
     */
    public function getTasks()
    {
        if (null === $this->tasks) {
            throw new ConfigurationNotLoadedException();
        }

        return $this->tasks;
    }

    private function loadTasks($config)
    {
        $tasks = $config['tasks'];
        $defaults = $config['default'];
        foreach (array_keys($tasks) as $key) {
            $tasks[$key] = $this->fillDefaultConfiguration($tasks[$key], array('source', 'destination'), $defaults);
        }

        return $tasks;
    }

    /**
     * @param $subject
     * @param $keys
     * @param $defaults
     *
     * @return mixed
     *
     * @throws ConfigurationMissingException
     */
    private function fillDefaultConfiguration($subject, $keys, $defaults)
    {
        foreach ($keys as $key) {
            if (!isset($subject[$key])) {
                if (!isset($defaults[$key])) {
                    throw new ConfigurationMissingException(
                        sprintf('Key %s is not defined and no default has been set.', $key));
                }

                $subject[$key] = $defaults[$key];
            }
        }

        return $subject;
    }
}
