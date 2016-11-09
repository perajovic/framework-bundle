<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Fixture;

use Filos\FrameworkBundle\Model\CurrentAccountInterface;
use Filos\FrameworkBundle\Model\Uuid;

class CurrentAccount implements CurrentAccountInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId(): Uuid
    {
        return new Uuid('efg-abc-123');
    }
}
