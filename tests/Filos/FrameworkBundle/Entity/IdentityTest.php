<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Entity;

use Tests\Filos\FrameworkBundle\TestCase\TestCase;
use Filos\FrameworkBundle\Entity\Identity;

class IdentityTest extends TestCase
{
    /**
     * @test
     *
     * @param int|null $id
     * @dataProvider provideIds
     */
    public function idIsSettledAndRetrieved(int $id = null)
    {
        $identity = new Identity($id);

        $this->assertSame($id, $identity->get());
    }

    /**
     * @return array
     */
    public function provideIds(): array
    {
        return [
            [null],
            [132],
        ];
    }
}
