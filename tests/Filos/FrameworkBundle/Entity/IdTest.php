<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Entity;

use Filos\FrameworkBundle\TestCase\TestCase;
use Filos\FrameworkBundle\Entity\Id;

class IdTest extends TestCase
{
    /**
     * @test
     *
     * @param int|null $value
     * @dataProvider provideValues
     */
    public function idIsSettledAndRetrieved(int $value = null)
    {
        $id = new Id($value);

        $this->assertSame($value, $id->get());
    }

    /**
     * @return array
     */
    public function provideValues(): array
    {
        return [
            [null],
            [132],
        ];
    }
}
