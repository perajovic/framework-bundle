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

use Filos\FrameworkBundle\Model\Attribute\StrongUuid;
use Filos\FrameworkBundle\TestCase\TestCase;

class StrongUuidTest extends TestCase
{
    /**
     * @test
     */
    public function newValueIsGenerated()
    {
        $uuid = new StrongUuid();

        $this->assertSame(96, strlen($uuid->get()));
    }

    /**
     * @test
     */
    public function oldValueIsUsed()
    {
        $value = '1fc8b8b7c33e4acf9d81e11947d32787576ba85f6b4a48a3965d0a9f9008878c46509c89af9e424f81896c1235ec1fc0';

        $uuid = new StrongUuid($value);

        $this->assertSame($value, $uuid->get());
        $this->assertSame($value, (string) $uuid);
    }
}
