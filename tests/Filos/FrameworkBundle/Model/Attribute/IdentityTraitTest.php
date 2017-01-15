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

use Filos\FrameworkBundle\Model\Attribute\IdentityTrait;
use Filos\FrameworkBundle\Model\Attribute\Uuid;
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

        $this->identity = $this->getObjectForTrait(IdentityTrait::class);
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
