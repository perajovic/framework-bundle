<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Filos\FrameworkBundle\EventListener\UpdateManagedByInfoListener;
use Filos\FrameworkBundle\Model\ManagedBy;
use Filos\FrameworkBundle\Model\Uuid;
use stdClass;
use Tests\Filos\FrameworkBundle\Fixture\UserContext;
use Tests\Filos\FrameworkBundle\TestCase\DoctrineListenerTestCase;

class UpdateManagedByInfoListenerTest extends DoctrineListenerTestCase
{
    /**
     * @var UpdateManagedByInfoListener
     */
    private $listener;

    /**
     * @var UserContext
     */
    private $userContext;

    /**
     * @var ManagedBy
     */
    private $managedBy;

    protected function setUp()
    {
        parent::setUp();

        $this->listener = new UpdateManagedByInfoListener();
        $this->userContext = new UserContext();
        $this->managedBy = ManagedBy::create(new Uuid(), 'Some\Type', 'john@doe.com');
    }

    /**
     * @test
     */
    public function ifEntityIsNotUserContextInstanceExecutionIsSkipped()
    {
        $this->ensureObject(new stdClass());

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->postUpdate($this->lifecycleEventArgs);
    }

    /**
     * @test
     */
    public function managedByIsNotUpdatedWhenItIsNotFound()
    {
        $this->ensureObject($this->userContext);
        $this->ensureManagedByResult(null, $this->userContext);

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->postUpdate($this->lifecycleEventArgs);
    }

    /**
     * @test
     */
    public function managedByInfoIsUpdatedWhenItIsFound()
    {
        $this->ensureObject($this->userContext);
        $this->ensureManagedByResult($this->managedBy, $this->userContext);
        $this->ensureEntityManagerIsFlushed();

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->postUpdate($this->lifecycleEventArgs);

        $this->assertSame('john@doe.com', $this->managedBy->getEmail());
        $this->assertSame('John', $this->managedBy->getFirstname());
        $this->assertSame('Doe', $this->managedBy->getLastname());
    }
}
