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
 * Date: 04.12.18
 * Time: 21:51.
 */

namespace DaSi\TwigCli\Tests\Compiler;

use DaSi\TwigCli\Compiler\Compiler;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $fileSystem;

    public function setUp()
    {
        $this->fileSystem = vfsStream::setup('root', null,
            array(
                'test.txt.twig' => "{% set world='world' %}Hello {{ world }}!",
            )
        );
    }

    public function testCompile()
    {
        $compiler = new Compiler();
        $compiler->compile($this->fileSystem->url(), 'test.txt.twig', $this->fileSystem->url());

        $this->assertTrue($this->fileSystem->hasChild('root/test.txt'));
        $this->assertEquals('Hello world!', $this->fileSystem->getChild('root/test.txt')->getContent());
    }
}
