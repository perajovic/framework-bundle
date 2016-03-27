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

namespace Filos\FrameworkBundle\Tests\Unit\Entity;

use Filos\FrameworkBundle\Test\TestCase;

class HashableTraitTest extends TestCase
{
    /**
     * @test
     */
    public function defaultHashIsNull()
    {
        $this->assertNull($this->hashable->getHash());
    }

    /**
     * @test
     * @dataProvider provideSalts
     */
    public function hashIsReturned($salt)
    {
        $this->hashable->setHash($salt);

        $this->assertEquals(40, strlen($this->hashable->getHash()));
    }

    public function provideSalts()
    {
        return [
            [null],
            ['foo123'],
        ];
    }

    protected function setUp()
    {
        $this->hashable = $this->getObjectForTrait(
            'Filos\FrameworkBundle\Entity\HashableTrait'
        );
    }
}
