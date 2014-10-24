<?php

namespace Codecontrol\FrameworkBundle\Tests\Functional\DependencyInjection;

use Codecontrol\FrameworkBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;

class ConfigurationTest extends AbstractConfigurationTestCase
{
    /**
     * @test
     * @dataProvider provideInvalidAppParams
     */
    public function appParamsAreInvalid($params)
    {
        $this->assertConfigurationIsInvalid([$params]);
    }

    /**
     * @test
     * @dataProvider provideValidAppParams
     */
    public function appParamsAreValid($params, $expected)
    {
        $this->assertProcessedConfigurationEquals($params, $expected);
    }

    public function provideInvalidAppParams()
    {
        return [
            [[5]],
            [['app123' => '123']],
            [['app' => '']],
        ];
    }

    public function provideValidAppParams()
    {
        return [
            [
                [
                    ['app' => ['foo']],
                    ['app' => ['bar']],
                ],
                ['app' => ['foo', 'bar']],
            ],
            [
                [
                    ['app' => ['foo' => 'bar']],
                ],
                ['app' => ['foo' => 'bar']],
            ],
        ];
    }

    protected function getConfiguration()
    {
        return new Configuration();
    }
}
