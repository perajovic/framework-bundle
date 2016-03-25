<?php

namespace Filos\FrameworkBundle;

use Filos\FrameworkBundle\DependencyInjection\Compiler\InputPass;
use Filos\FrameworkBundle\DependencyInjection\Compiler\InterceptorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FilosFrameworkBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new InterceptorPass());
        $container->addCompilerPass(new InputPass());
    }
}
