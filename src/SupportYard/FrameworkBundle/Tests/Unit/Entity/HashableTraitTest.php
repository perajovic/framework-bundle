<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Entity;

use SupportYard\FrameworkBundle\Test\TestCase;

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
            'SupportYard\FrameworkBundle\Entity\HashableTrait'
        );
    }
}
