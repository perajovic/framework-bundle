<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Entity;

use Codecontrol\FrameworkBundle\Test\TestCase;

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
            'Codecontrol\FrameworkBundle\Entity\HashableTrait'
        );
    }
}
