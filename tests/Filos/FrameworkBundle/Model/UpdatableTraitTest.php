<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Tests\Model;

use DateTime;
use Filos\FrameworkBundle\Model\UpdatableTrait;
use Filos\FrameworkBundle\TestCase\TestCase;

class UpdatableTraitTest extends TestCase
{
    /**
     * @var UpdatableTrait
     */
    private $creatable;

    protected function setUp()
    {
        parent::setUp();

        $this->creatable = $this->getObjectForTrait('Filos\FrameworkBundle\Model\UpdatableTrait');
    }

    /**
     * @test
     */
    public function checkInitialState()
    {
        $this->assertNull($this->creatable->getUpdatedBy());
        $this->assertNull($this->creatable->getUpdatedAt());
    }

    /**
     * @test
     * @dataProvider provideFieldValues
     *
     * @param null|string   $updatedBy
     * @param null|DateTime $updatedAt
     */
    public function fieldValuesAreRetrieved(?string $updatedBy, ?DateTime $updatedAt)
    {
        $this->setNonPublicPropertyValue($this->creatable, 'updatedBy', $updatedBy);
        $this->setNonPublicPropertyValue($this->creatable, 'updatedAt', $updatedAt);

        $this->assertSame($updatedBy, $this->creatable->getUpdatedBy());
        $this->assertSame($updatedAt, $this->creatable->getUpdatedAt());
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
