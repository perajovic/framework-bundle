<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Tests\Model;

use DateTime;
use Filos\FrameworkBundle\Model\ManagedBy;
use Filos\FrameworkBundle\Model\UpdatableTrait;
use Filos\FrameworkBundle\Model\Uuid;
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
     */
    public function fieldValuesAreRetrieved()
    {
        $updatedBy = ManagedBy::create(new Uuid(), 'stdClass', 'john@doe.com');
        $updatedAt = new DateTime('now');

        $this->creatable->setUpdatedBy($updatedBy);
        $this->creatable->setUpdatedAt($updatedAt);

        $this->assertSame($updatedBy, $this->creatable->getUpdatedBy());
        $this->assertSame($updatedAt, $this->creatable->getUpdatedAt());
    }
}
