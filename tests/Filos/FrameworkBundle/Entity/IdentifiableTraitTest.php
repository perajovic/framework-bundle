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

namespace Filos\FrameworkBundle\Tests\Entity;

use Filos\FrameworkBundle\Test\TestCase;

class IdentifiableTraitTest extends TestCase
{
    private $identifiable;

    public function setUp()
    {
        parent::setUp();

        $this->identifiable = $this->getObjectForTrait('Filos\FrameworkBundle\Entity\IdentifiableTrait');
    }

    /**
     * @test
     */
    public function checkInitialState()
    {
        $this->assertNull($this->identifiable->getId());
    }

    /**
     * @test
     * @dataProvider provideId
     */
    public function idIsSettledAndRetrieved($id, $expected)
    {
        $this->identifiable->setId($id);

        $this->assertSame($expected, $this->identifiable->getId());
    }

    /**
     * @return array
     */
    public function provideId(): array
    {
        return [
            [1, 1],
            ['1', 1],
            [null, null],
        ];
    }
}
