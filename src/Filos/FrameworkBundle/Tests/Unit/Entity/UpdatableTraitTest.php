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
            'Filos\FrameworkBundle\Entity\UpdatableTrait'
        );
    }
}
