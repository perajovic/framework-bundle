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
use Filos\FrameworkBundle\Model\ManagedBy;
use Filos\FrameworkBundle\Model\Uuid;
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
     */
    public function fieldValuesAreRetrieved()
    {
        $createdBy = ManagedBy::create(new Uuid(), 'stdClass', 'john@doe.com');
        $createdAt = new DateTime('now');

        $this->creatable->setCreatedBy($createdBy);
        $this->creatable->setCreatedAt($createdAt);

        $this->assertSame($createdBy, $this->creatable->getCreatedBy());
        $this->assertSame($createdAt, $this->creatable->getCreatedAt());
    }
}
