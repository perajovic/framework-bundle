<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Model\Attribute;

use Filos\FrameworkBundle\Model\Attribute\Uuid;
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
        $this->assertSame('facf4be0-0b37-48ee-92c5-e2ba50bc47e6', (string) $uuid);
    }
}
