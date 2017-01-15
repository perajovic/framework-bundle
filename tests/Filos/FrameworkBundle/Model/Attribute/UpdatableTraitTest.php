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
use Filos\FrameworkBundle\Model\Attribute\UpdatableTrait;
use Filos\FrameworkBundle\Model\Attribute\Uuid;
use Filos\FrameworkBundle\Model\ManagedBy;
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

        $this->creatable = $this->getObjectForTrait(UpdatableTrait::class);
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
