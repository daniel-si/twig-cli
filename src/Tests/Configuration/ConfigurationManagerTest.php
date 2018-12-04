<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 03.12.18
 * Time: 17:44.
 */

namespace DaSi\TwigCli\Tests\Configuration;

use DaSi\TwigCli\Configuration\ConfigurationManager;
use DaSi\TwigCli\Configuration\ConfigurationMissingException;
use DaSi\TwigCli\Configuration\ConfigurationNotLoadedException;
use PHPUnit\Framework\TestCase;

final class ConfigurationManagerTest extends TestCase
{
    public function testGetTasksWithDefaults()
    {
        $config = <<<'EOF'
default:
    source: 'src'
    destination: 'dest'
tasks:
    test:
        template: 'template'
        deploy: 'zip'
EOF;
        $this->assertTasksEqual(
            [
                'test' => [
                    'source' => 'src',
                    'destination' => 'dest',
                    'template' => 'template',
                    'deploy' => 'zip',
                ],
            ],
            $config
        );
    }

    public function testGetTasksThrowsIfSourceMissing()
    {
        $config = <<<'EOF'
default:
    destination: 'dest'
tasks:
    test:
        template: 'template'
        deploy: 'zip'
EOF;

        $this->expectException(ConfigurationMissingException::class);
        $this->createConfigurationManager($config);
    }

    public function testGetTasksThrowsIfDestinationMissing()
    {
        $config = <<<'EOF'
default:
    source: 'src'
tasks:
    test:
        template: 'template'
        deploy: 'zip'
EOF;

        $this->expectException(ConfigurationMissingException::class);
        $this->createConfigurationManager($config);
    }

    public function testGetTasksThrowsIfConfigurationNotLoaded()
    {
        $this->expectException(ConfigurationNotLoadedException::class);

        $manager = new ConfigurationManager();
        $manager->getTasks();
    }

    /**
     * @param string $config
     * @return ConfigurationManager
     */
    private function createConfigurationManager($config)
    {
        $fileName = \tempnam(\sys_get_temp_dir(), 'TST');
        \file_put_contents($fileName, $config);

        $manager = new ConfigurationManager();
        $manager->loadConfiguration($fileName);

        \unlink($fileName);

        return $manager;
    }

    private function assertTasksEqual($expectedConfig, $testConfig)
    {
        $manager = $this->createConfigurationManager($testConfig);
        $this->assertEquals($expectedConfig, $manager->getTasks());
    }
}
