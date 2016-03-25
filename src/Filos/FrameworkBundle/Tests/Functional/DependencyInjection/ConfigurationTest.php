<?php

namespace Filos\FrameworkBundle\Tests\Functional\DependencyInjection;

use Filos\FrameworkBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;
use stdClass;

class ConfigurationTest extends AbstractConfigurationTestCase
{
    /**
     * @test
     * @dataProvider provideInvalidConfiguration
     */
    public function configurationIsInvalid($params)
    {
        $this->assertConfigurationIsInvalid([$params]);
    }

    /**
     * @test
     * @dataProvider provideValidConfiguration
     */
    public function configurationIsValid($params, $expected)
    {
        $this->assertProcessedConfigurationEquals($params, $expected);
    }

    public function provideInvalidConfiguration()
    {
        return [
            [[5, 'truncate_tables_between_tests' => false]],
            [['app123' => '123', 'truncate_tables_between_tests' => false]],
            [['app' => '', 'truncate_tables_between_tests' => false]],
            [['app' => ['foo'], 'truncate_tables_between_tests' => 123]],
            [['app' => ['foo'], 'truncate_tables_between_tests' => 'foo']],
            [['app' => ['foo'], 'truncate_tables_between_tests' => ['foo']]],
            [['app' => ['foo'], 'truncate_tables_between_tests' => new stdClass()]],
        ];
    }

    public function provideValidConfiguration()
    {
        return [
            [
                [
                    ['app' => ['foo']],
                    ['app' => ['bar']],
                ],
                [
                    'app' => ['foo', 'bar'],
                    'truncate_tables_between_tests' => false,
                ],
            ],
            [
                [
                    ['app' => ['foo' => 'bar']],
                    ['truncate_tables_between_tests' => false],
                ],
                [
                    'app' => ['foo' => 'bar'],
                    'truncate_tables_between_tests' => false,
                ],
            ],
            [
                [
                    ['app' => ['foo' => 'bar']],
                    ['truncate_tables_between_tests' => true],
                ],
                [
                    'app' => ['foo' => 'bar'],
                    'truncate_tables_between_tests' => true,
                ],
            ],
        ];
    }

    protected function getConfiguration()
    {
        return new Configuration();
    }
}
