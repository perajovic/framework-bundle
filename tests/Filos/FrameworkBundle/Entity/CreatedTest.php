<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Tests\Filos\FrameworkBundle\Entity;

use DateTime;
use Filos\FrameworkBundle\Entity\Created;
use Tests\Filos\FrameworkBundle\Fixture\ByUser;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

class CreatedTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideValues
     */
    public function fieldsAreSettledAndRetrieved($by, $at)
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