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
    /**
     * {@inheritdoc}
     */
    public function render($name, array $parameters = [])
    {
        return sprintf('  %s %s %s   ', $name, array_keys($parameters)[0], array_values($parameters)[0]);
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function supports($name)
    {
    }
}
