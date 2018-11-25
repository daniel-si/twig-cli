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

require_once __DIR__.'/../vendor/autoload.php';

use DaSi\TwigCli\Command\CompileCommand;
use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new CompileCommand(new \DaSi\TwigCli\Configuration\ConfigurationManager()));

$app->run();
