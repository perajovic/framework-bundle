<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Model;

use Filos\FrameworkBundle\TestCase\TestCase;
use Filos\FrameworkBundle\Model\Hash;

class HashTest extends TestCase
{
    /**
     * @test
     *
     * @param string|null $salt
     * @dataProvider provideSalts
     */
    public function hashIsSettledAndRetrieved(?string $salt)
    {
        $hash = new Hash($salt);

        $this->assertEquals(64, strlen($hash->get()));
        $this->assertEquals(64, strlen((string) $hash));
    }

    /**
     * @return array
     */
    public function provideSalts(): array
    {
        return [
            [null],
            ['foo123'],
        ];
    }
}
