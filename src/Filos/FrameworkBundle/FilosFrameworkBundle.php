<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

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

        $container
            ->addCompilerPass(new InterceptorPass())
            ->addCompilerPass(new InputPass());
    }
}
