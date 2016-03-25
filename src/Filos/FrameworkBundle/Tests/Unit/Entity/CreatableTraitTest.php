<?php

namespace Filos\FrameworkBundle\Tests\Unit\Entity;

use Filos\FrameworkBundle\Test\TestCase;
use DateTime;

class CreatableTraitTest extends TestCase
{
    /**
     * @test
     */
    public function checkInitialState()
    {
        $this->assertNull($this->creatable->getCreatedBy());
        $this->assertNull($this->creatable->getCreatedAt());
    }

    /**
     * @test
     * @dataProvider provideFieldValues
     */
    public function fieldsAreSettledAndRetrieved($createdBy, $createdAt)
    {
        $this->creatable->setCreatedBy($createdBy);
        $this->creatable->setCreatedAt($createdAt);

        $this->assertSame($createdBy, $this->creatable->getCreatedBy());
        $this->assertSame($createdAt, $this->creatable->getCreatedAt());
    }

    public function provideFieldValues()
    {
        return [
            [null, null],
            [123, new DateTime('now')],
        ];
    }

    protected function setUp()
    {
        $this->creatable = $this->getObjectForTrait(
            'Filos\FrameworkBundle\Entity\CreatableTrait'
        );
    }
}
