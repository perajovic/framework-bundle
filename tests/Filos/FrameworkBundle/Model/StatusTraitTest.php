<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Tests\Model;

use Filos\FrameworkBundle\TestCase\TestCase;
use Tests\Filos\FrameworkBundle\Fixture\Status;

class StatusTraitTest extends TestCase
{
    /**
     * @var Status
     */
    private $status;

    protected function setUp()
    {
        parent::setUp();

        $this->status = new Status();
    }

    /**
     * @test
     */
    public function statusIsRetrieved()
    {
        $this->setNonPublicPropertyValue($this->status, 'status', 'active');
        $this->assertSame('active', $this->status->getStatus());
    }

    /**
     * @test
     */
    public function availableStatusesAreRetrieved()
    {
        $this->assertSame(['foo', 'bar'], Status::getStatuses());
    }
}
