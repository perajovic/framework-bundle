<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Model;

use Filos\FrameworkBundle\Model\Hash;
use Filos\FrameworkBundle\TestCase\TestCase;

class HashTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider provideSalts
     */
    public function hashIsSettledAndRetrieved(?string $salt)
    {
        $hash = new Hash($salt);

        $this->assertEquals(64, strlen($hash->get()));
        $this->assertEquals(64, strlen((string) $hash));
    }

    public function provideSalts(): array
    {
        return [
            [null],
            ['foo123'],
        ];
    }
}
