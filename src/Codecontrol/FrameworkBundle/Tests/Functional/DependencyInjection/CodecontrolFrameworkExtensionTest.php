<?php

namespace Codecontrol\FrameworkBundle\Tests\Functional\DependencyInjection;

use Codecontrol\FrameworkBundle\DependencyInjection\CodecontrolFrameworkExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class CodecontrolFrameworkExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function containerParametersAreSettled()
    {
        $appParam = ['foo' => 'bar'];

        $this->load();

        $this->assertContainerBuilderHasParameter(
            'codecontrol_framework.app',
            $appParam
        );
    }

    protected function getMinimalConfiguration()
    {
        return ['app' => ['foo' => 'bar']];
    }

    protected function getContainerExtensions()
    {
        return [new CodecontrolFrameworkExtension()];
    }
}
