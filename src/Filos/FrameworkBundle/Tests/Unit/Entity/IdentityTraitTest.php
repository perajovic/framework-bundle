<?php

namespace Filos\FrameworkBundle\Tests\Unit\Entity;

use Filos\FrameworkBundle\Test\TestCase;

class IdentityTraitTest extends TestCase
{
    /**
     * @test
     */
    public function defaultIdIsNull()
    {
        $this->assertNull($this->identity->getId());
    }

    /**
     * @test
     */
    public function idIsRetrieved()
    {
        $id = 123;

        $this->setNonPublicPropertyValue($this->identity, 'id', $id);

        $this->assertSame($id, $this->identity->getId());
    }

    protected function setUp()
    {
        $this->identity = $this->getObjectForTrait(
            'Filos\FrameworkBundle\Entity\IdentityTrait'
        );
    }
}
