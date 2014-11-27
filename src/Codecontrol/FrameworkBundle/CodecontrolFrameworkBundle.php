<?php

namespace Codecontrol\FrameworkBundle;

use Codecontrol\FrameworkBundle\DependencyInjection\Compiler\AppRequestPass;
use Codecontrol\FrameworkBundle\DependencyInjection\Compiler\InterceptorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CodecontrolFrameworkBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new InterceptorPass());
        $container->addCompilerPass(new AppRequestPass());
    }
}
