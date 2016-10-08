<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Entity;

use DateTime;
use Filos\FrameworkBundle\Entity\ByInterface;
use Filos\FrameworkBundle\Entity\Created;
use Tests\Filos\FrameworkBundle\Fixture\ByUser;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

class CreatedTest extends TestCase
{
    /**
     * @test
     *
     * @param ByInterface|null $by
     * @param DateTime|null    $at
     * @dataProvider provideValues
     */
    public function fieldsAreSettledAndRetrieved(ByInterface $by = null, DateTime $at = null)
    {
        $created = new Created($by, $at);

        $this->assertSame($by, $created->getBy());
        $this->assertSame($at, $created->getAt());
    }

    /**
     * @return array
     */
    public function provideValues(): array
    {
        return [
            [null, null],
            [new ByUser(), new DateTime('now')],
        ];
    }
}
