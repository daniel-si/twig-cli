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
 * Time: 11:47.
 */

namespace DaSi\TwigCli\Command;

use DaSi\TwigCli\Compiler\Compiler;
use DaSi\TwigCli\Configuration\ConfigurationManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CompileCommand extends Command
{
    private $configurationManager;

    public function __construct(ConfigurationManager $configurationManager)
    {
        parent::__construct();

        $this->configurationManager = $configurationManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('compile');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->configurationManager->loadConfiguration('project.yml');
        $compiler = new Compiler();

        foreach ($this->configurationManager->getTasks() as $task) {
            $output->write(sprintf('Compiling %s...', $task['template']));

            $compiler->compile(
                $task['source'],
                $task['template'],
                $task['destination']
            );

            $output->writeln(' Success.');
        }
    }
}
