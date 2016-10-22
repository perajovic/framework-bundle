<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Tests\Model;

use DateTime;
use Filos\FrameworkBundle\Model\CreatableTrait;
use Filos\FrameworkBundle\TestCase\TestCase;

class CreatableTraitTest extends TestCase
{
    /**
     * @var CreatableTrait
     */
    private $creatable;

    protected function setUp()
    {
        parent::setUp();

        $this->creatable = $this->getObjectForTrait('Filos\FrameworkBundle\Model\CreatableTrait');
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
     *
     * @param null|string   $createdBy
     * @param null|DateTime $createdAt
     */
    public function fieldValuesAreRetrieved(?string $createdBy, ?DateTime $createdAt)
    {
        $this->setNonPublicPropertyValue($this->creatable, 'createdBy', $createdBy);
        $this->setNonPublicPropertyValue($this->creatable, 'createdAt', $createdAt);

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
            ['123-abc', new DateTime('now')],
        ];
    }
}
