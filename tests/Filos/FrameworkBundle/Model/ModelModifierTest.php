<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Model;

use Filos\FrameworkBundle\Model\Attribute\Uuid;
use Filos\FrameworkBundle\Model\ModelModifier;
use Filos\FrameworkBundle\TestCase\TestCase;

class ModelModifierTest extends TestCase
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
        $modifier = ModelModifier::create($this->uuid, 'Foo\Bar', 'john@doe.com', 'John', 'Doe');

        $this->assertSame($this->uuid, $modifier->getId());
        $this->assertSame('Foo\Bar', $modifier->getType());
        $this->assertSame('john@doe.com', $modifier->getEmail());
        $this->assertSame('John', $modifier->getFirstname());
        $this->assertSame('Doe', $modifier->getLastname());
        $this->assertTrue($modifier->isDeleted());
    }

    /**
     * @test
     */
    public function objectIsCreatedWithoutOptionalArguments()
    {
        $modifier = ModelModifier::create($this->uuid, 'Foo\Bar', 'john@doe.com');

        $this->assertSame($this->uuid, $modifier->getId());
        $this->assertSame('Foo\Bar', $modifier->getType());
        $this->assertSame('john@doe.com', $modifier->getEmail());
        $this->assertNull($modifier->getFirstname());
        $this->assertNull($modifier->getLastname());
        $this->assertTrue($modifier->isDeleted());
    }

    /**
     * @test
     */
    public function objectIsUpdated()
    {
        $modifier = ModelModifier::create($this->uuid, 'Foo\Bar', 'john@doe.com', 'John', 'Doe');

        $modifier->update('john1@doe.com', 'John1', 'Doe1');

        $this->assertSame('john1@doe.com', $modifier->getEmail());
        $this->assertSame('John1', $modifier->getFirstname());
        $this->assertSame('Doe1', $modifier->getLastname());
    }

    /**
     * @test
     */
    public function objectIsMarkedAsDeleted()
    {
        $modifier = ModelModifier::create($this->uuid, 'Foo\Bar', 'john@doe.com');

        $modifier->markAsDeleted();

        $this->assertFalse($modifier->isDeleted());
    }
}
