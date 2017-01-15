<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Tests\Model\Attribute;

use DateTime;
use Filos\FrameworkBundle\Model\Attribute\CreatableTrait;
use Filos\FrameworkBundle\Model\Attribute\Uuid;
use Filos\FrameworkBundle\Model\ManagedBy;
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

        $this->creatable = $this->getObjectForTrait(CreatableTrait::class);
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
