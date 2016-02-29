<?php

namespace SupportYard\FrameworkBundle;

use SupportYard\FrameworkBundle\DependencyInjection\Compiler\InputPass;
use SupportYard\FrameworkBundle\DependencyInjection\Compiler\InterceptorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SupportYardFrameworkBundle extends Bundle
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
