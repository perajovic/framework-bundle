<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle;

use Filos\FrameworkBundle\DependencyInjection\Compiler\InputPass;
use Filos\FrameworkBundle\DependencyInjection\Compiler\InterceptorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FilosFrameworkBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new InterceptorPass())
            ->addCompilerPass(new InputPass());
    }
}
