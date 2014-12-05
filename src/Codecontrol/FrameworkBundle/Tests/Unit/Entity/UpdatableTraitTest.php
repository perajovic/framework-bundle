<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Entity;

use Codecontrol\FrameworkBundle\Test\TestCase;
use DateTime;

class UpdatableTraitTest extends TestCase
{
    /**
     * @test
     */
    public function checkInitialState()
    {
        $this->assertNull($this->updatable->getUpdatedBy());
        $this->assertNull($this->updatable->getUpdatedAt());
    }

    /**
     * @test
     * @dataProvider provideFieldValues
     */
    public function fieldsAreSettledAndRetrieved($updatedBy, $updatedAt)
    {
        $this->updatable->setUpdatedBy($updatedBy);
        $this->updatable->setUpdatedAt($updatedAt);

        $this->assertSame($updatedBy, $this->updatable->getUpdatedBy());
        $this->assertSame($updatedAt, $this->updatable->getUpdatedAt());
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
        $this->updatable = $this->getObjectForTrait(
            'Codecontrol\FrameworkBundle\Entity\UpdatableTrait'
        );
    }
}
