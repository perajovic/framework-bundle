<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\DependencyInjection;

use Filos\FrameworkBundle\DependencyInjection\Configuration;
use Filos\FrameworkBundle\TestCase\TestCase;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use stdClass;

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

    public function provideValidConfiguration(): array
    {
        return [
            [
                [[
                    'app' => [],
                ]],
                [
                    'app' => [
                        'no_cache' => false,
                        'send_flatten' => true,
                        'status_code' => 200,
                        'page_title' => null,
                        'action_callback' => null,
                        'action_data' => [],
                        'interceptors' => [],
                        'default_url_catcher_route' => '',
                    ],
                    'truncate_tables_between_tests' => false,
                ],
            ],
            [
                [[
                    'app' => [
                        'no_cache' => true,
                        'send_flatten' => false,
                        'status_code' => 201,
                        'page_title' => 'Page Title',
                        'action_callback' => 'action/callback',
                        'action_data' => ['foo' => 'bar', 'abc' => '123', 5, new stdClass()],
                        'interceptors' => ['first', 'second'],
                        'default_url_catcher_route' => 'some_route',
                    ],
                    'truncate_tables_between_tests' => true,
                ]],
                [
                    'app' => [
                        'no_cache' => true,
                        'send_flatten' => false,
                        'status_code' => 201,
                        'page_title' => 'Page Title',
                        'action_callback' => 'action/callback',
                        'action_data' => ['foo' => 'bar', 'abc' => '123', 5, new stdClass()],
                        'interceptors' => ['first', 'second'],
                        'default_url_catcher_route' => 'some_route',
                    ],
                    'truncate_tables_between_tests' => true,
                ],
            ],
        ];
    }

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }
}
