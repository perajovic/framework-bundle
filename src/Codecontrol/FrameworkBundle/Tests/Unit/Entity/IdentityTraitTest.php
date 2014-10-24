<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Entity;

use Codecontrol\FrameworkBundle\Test\TestCase;

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
            'Codecontrol\FrameworkBundle\Entity\IdentityTrait'
        );
    }
}
