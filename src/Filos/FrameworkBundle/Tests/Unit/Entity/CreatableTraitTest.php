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

class CreatableTraitTest extends TestCase
{
    private $creatable;

    public function setUp()
    {
        $this->creatable = $this->getObjectForTrait('Filos\FrameworkBundle\Entity\CreatableTrait');
    }

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

    /**
     * @return array
     */
    public function provideFieldValues(): array
    {
        return [
            [null, null],
            [123, new DateTime('now')],
        ];
    }
}
