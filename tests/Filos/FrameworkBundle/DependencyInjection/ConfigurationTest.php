<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\DependencyInjection;

use Filos\FrameworkBundle\DependencyInjection\Configuration;
use stdClass;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Filos\FrameworkBundle\TestCase\TestCase;

class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     * @dataProvider provideInvalidConfiguration
     */
    public function configurationIsInvalid($params)
    {
        $this->assertConfigurationIsInvalid([$params]);
    }

    /**
     * @return array
     */
    public function provideInvalidConfiguration(): array
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

    /**
     * @test
     * @dataProvider provideValidConfiguration
     */
    public function configurationIsValid($params, $expected)
    {
        $this->assertProcessedConfigurationEquals($params, $expected);
    }

    /**
     * @return array
     */
    public function provideValidConfiguration(): array
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

    /**
     * @return Configuration
     */
    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }
}
