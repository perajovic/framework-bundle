<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Fixture;

use Symfony\Component\Templating\EngineInterface;

class Engine implements EngineInterface
{
    public function render($name, array $parameters = [])
    {
        return sprintf('  %s %s %s   ', $name, array_keys($parameters)[0], array_values($parameters)[0]);
    }

    public function exists($name)
    {
    }

    public function supports($name)
    {
    }
}
