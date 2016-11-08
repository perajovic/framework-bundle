<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Tests\Model;

use Filos\FrameworkBundle\Model\IdentityTrait;
use Filos\FrameworkBundle\Model\Uuid;
use Filos\FrameworkBundle\TestCase\TestCase;

class IdentityTraitTest extends TestCase
{
    /**
     * @var IdentityTrait
     */
    private $identity;

    protected function setUp()
    {
        parent::setUp();

        $this->identity = $this->getObjectForTrait('Filos\FrameworkBundle\Model\IdentityTrait');
    }

    /**
     * @test
     */
    public function fieldValueIsRetrieved()
    {
        $uuid = new Uuid();

        $this->setNonPublicPropertyValue($this->identity, 'id', $uuid);

        $this->assertSame($uuid, $this->identity->getId());
    }
}
