<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Entity;

use Tests\Filos\FrameworkBundle\TestCase\TestCase;
use Filos\FrameworkBundle\Entity\Hash;

class HashTest extends TestCase
{
    /**
     * @test
     *
     * @param string|null $salt
     * @dataProvider provideSalts
     */
    public function hashIsSettledAndRetrieved(string $salt = null)
    {
        $hash = new Hash($salt);

        $this->assertEquals(40, strlen($hash->get()));
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
