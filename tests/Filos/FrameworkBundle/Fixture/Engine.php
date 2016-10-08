<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
