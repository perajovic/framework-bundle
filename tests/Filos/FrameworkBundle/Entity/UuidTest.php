<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Entity;

use Filos\FrameworkBundle\Entity\Uuid;
use Filos\FrameworkBundle\TestCase\TestCase;

class UuidTest extends TestCase
{
    /**
     * @test
     */
    public function newValueIsGenerated()
    {
        $uuid = new Uuid();

        $this->assertSame(36, strlen($uuid->get()));
    }

    /**
     * @test
     */
    public function oldValueIsUsed()
    {
        $uuid = new Uuid('facf4be0-0b37-48ee-92c5-e2ba50bc47e6');

        $this->assertSame('facf4be0-0b37-48ee-92c5-e2ba50bc47e6', $uuid->get());
    }
}
