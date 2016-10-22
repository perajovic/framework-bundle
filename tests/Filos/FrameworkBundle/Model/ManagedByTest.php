<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Model;

use Filos\FrameworkBundle\Model\Uuid;
use Filos\FrameworkBundle\TestCase\TestCase;
use Filos\FrameworkBundle\Model\ManagedBy;

class ManagedByTest extends TestCase
{
    /**
     * @var Uuid
     */
    private $uuid;

    protected function setUp()
    {
        parent::setUp();

        $this->uuid = new Uuid('123-abc');
    }

    /**
     * @test
     */
    public function objectIsCreatedWithAllArguments()
    {
        $managedBy = ManagedBy::create($this->uuid, 'Foo\Bar', 'john@doe.com', 'John', 'Doe');

        $this->assertSame($this->uuid, $managedBy->getId());
        $this->assertSame('Foo\Bar', $managedBy->getType());
        $this->assertSame('john@doe.com', $managedBy->getEmail());
        $this->assertSame('John', $managedBy->getFirstname());
        $this->assertSame('Doe', $managedBy->getLastname());
        $this->assertTrue($managedBy->isExists());
    }

    /**
     * @test
     */
    public function objectIsCreatedWithoutOptionalArguments()
    {
        $managedBy = ManagedBy::create($this->uuid, 'Foo\Bar', 'john@doe.com');

        $this->assertSame($this->uuid, $managedBy->getId());
        $this->assertSame('Foo\Bar', $managedBy->getType());
        $this->assertSame('john@doe.com', $managedBy->getEmail());
        $this->assertNull($managedBy->getFirstname());
        $this->assertNull($managedBy->getLastname());
        $this->assertTrue($managedBy->isExists());
    }

    /**
     * @test
     */
    public function objectIsUpdated()
    {
        $managedBy = ManagedBy::create($this->uuid, 'Foo\Bar', 'john@doe.com', 'John', 'Doe');

        $managedBy->update('john1@doe.com', 'John1', 'Doe1');

        $this->assertSame('john1@doe.com', $managedBy->getEmail());
        $this->assertSame('John1', $managedBy->getFirstname());
        $this->assertSame('Doe1', $managedBy->getLastname());
    }

    /**
     * @test
     */
    public function objectIsMarkedAsNonExisting()
    {
        $managedBy = ManagedBy::create($this->uuid, 'Foo\Bar', 'john@doe.com');

        $managedBy->notExists();

        $this->assertFalse($managedBy->isExists());
    }
}
