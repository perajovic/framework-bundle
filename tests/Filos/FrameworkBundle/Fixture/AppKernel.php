<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Fixture;

use Filos\FrameworkBundle\FilosFrameworkBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle as SymfonyFrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles(): array
    {
        return [new TwigBundle(), new SymfonyFrameworkBundle(), new FilosFrameworkBundle()];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config_'.$this->getEnvironment().'.yml');
    }

    public function getCacheDir(): string
    {
        return __DIR__.'/../../../../var/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return __DIR__.'/../../../../var/logs';
    }
}
