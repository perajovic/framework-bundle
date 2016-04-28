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

class HashableTraitTest extends TestCase
{
    private $hashable;

    public function setUp()
    {
        parent::setUp();

        $this->hashable = $this->getObjectForTrait('Filos\FrameworkBundle\Entity\HashableTrait');
    }

    /**
     * @test
     */
    public function checkInitialState()
    {
        $this->assertNull($this->hashable->getHash());
    }

    /**
     * @test
     * @dataProvider provideSalts
     */
    public function hashIsSettledAndRetrieved($salt)
    {
        $this->hashable->setHash($salt);

        $this->assertEquals(40, strlen($this->hashable->getHash()));
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
