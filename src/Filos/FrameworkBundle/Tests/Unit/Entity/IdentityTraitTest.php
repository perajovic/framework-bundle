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
