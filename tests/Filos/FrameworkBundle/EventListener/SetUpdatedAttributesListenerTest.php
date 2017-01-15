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

use DateTime;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Filos\FrameworkBundle\EventListener\SetUpdatedAttributesListener;
use Filos\FrameworkBundle\Model\Attribute\Uuid;
use Filos\FrameworkBundle\Model\ManagedBy;
use Filos\FrameworkBundle\RequestContext\RequestContext;
use stdClass;
use Tests\Filos\FrameworkBundle\Fixture\UpdatableEntity;
use Tests\Filos\FrameworkBundle\Fixture\UserContext;
use Tests\Filos\FrameworkBundle\TestCase\DoctrineListenerTestCase;

class SetUpdatedAttributesListenerTest extends DoctrineListenerTestCase
{
    /**
     * @var SetUpdatedAttributesListener
     */
    private $listener;

    /**
     * @var RequestContext
     */
    private $requestContext;

    /**
     * @var UserContext
     */
    private $userContext;

    /**
     * @var UpdatableEntity
     */
    private $updatableEntity;

    /**
     * @var ManagedBy
     */
    private $managedBy;

    protected function setUp()
    {
        parent::setUp();

        $this->lifecycleEventArgs = $this->createMockFor(PreUpdateEventArgs::class);
        $this->requestContext = new RequestContext();
        $this->userContext = new UserContext();
        $this->updatableEntity = new UpdatableEntity();
        $this->managedBy = ManagedBy::create(new Uuid('111-222-aaa'), 'Some\Type', 'j@doe.com');
        $this->listener = new SetUpdatedAttributesListener($this->requestContext);
    }

    /**
     * @test
     */
    public function ifEntityIsNotCreatableTraitInstanceExecutionIsSkipped()
    {
        $this->ensureObject(new stdClass());
        $this->ensureObjectManagerIsNotCalled();

        /* @var PreUpdateEventArgs $this->lifecycleEventArgs */
        $this->listener->preUpdate($this->lifecycleEventArgs);
    }

    /**
     * @test
     */
    public function ifUpdatedAtIsNotSettledNewDateTimeWillBeSet()
    {
        $this->ensureObject($this->updatableEntity);
        $this->ensureObjectManagerIsNotCalled();

        $this->assertNull($this->updatableEntity->getUpdatedAt());

        /* @var PreUpdateEventArgs $this->lifecycleEventArgs */
        $this->listener->preUpdate($this->lifecycleEventArgs);

        $this->assertInstanceOf(DateTime::class, $this->updatableEntity->getUpdatedAt());
    }

    /**
     * @test
     */
    public function ifUpdatedAtIsSettledNewDateTimeWillNotBeSet()
    {
        $date = new DateTime('now');
        $this->updatableEntity->setUpdatedAt($date);

        $this->ensureObject($this->updatableEntity);
        $this->ensureObjectManagerIsNotCalled();

        /* @var PreUpdateEventArgs $this->lifecycleEventArgs */
        $this->listener->preUpdate($this->lifecycleEventArgs);

        $this->assertSame($date, $this->updatableEntity->getUpdatedAt());
    }

    /**
     * @test
     */
    public function ifUserContextDoesNotExistNewUpdatedByWillNotBeSet()
    {
        $this->ensureObject($this->updatableEntity);
        $this->ensureObjectManagerIsNotCalled();

        /* @var PreUpdateEventArgs $this->lifecycleEventArgs */
        $this->listener->preUpdate($this->lifecycleEventArgs);

        $this->assertNull($this->updatableEntity->getUpdatedBy());
    }

    /**
     * @test
     */
    public function ifUpdatedByIsChangedNewUpdatedByWillNotBeSet()
    {
        $this->requestContext->setUser($this->userContext);

        $this->ensureObject($this->updatableEntity);
        $this->ensureObjectManagerIsNotCalled();
        $this->ensureUpdatedByFieldChange(true);

        /* @var PreUpdateEventArgs $this->lifecycleEventArgs */
        $this->listener->preUpdate($this->lifecycleEventArgs);
    }

    /**
     * @test
     */
    public function existingManagedByIsSettled()
    {
        $this->requestContext->setUser($this->userContext);

        $this->ensureObject($this->updatableEntity);
        $this->ensureManagedByResult($this->managedBy, $this->userContext);
        $this->ensureUpdatedByFieldChange(false);

        /* @var PreUpdateEventArgs $this->lifecycleEventArgs */
        $this->listener->preUpdate($this->lifecycleEventArgs);

        $this->assertSame($this->managedBy, $this->updatableEntity->getUpdatedBy());
    }

    /**
     * @test
     */
    public function newManagedByIsCreatedAndSettled()
    {
        $this->requestContext->setUser($this->userContext);

        $this->ensureObject($this->updatableEntity);
        $this->ensureManagedByResult(null, $this->userContext);
        $this->ensureManagedByIsPersisted();
        $this->ensureUpdatedByFieldChange(false);

        /* @var PreUpdateEventArgs $this->lifecycleEventArgs */
        $this->listener->preUpdate($this->lifecycleEventArgs);

        $createdBy = $this->updatableEntity->getUpdatedBy();

        $this->assertSame('123-abc-efg', $createdBy->getId()->get());
        $this->assertSame('Tests\Filos\FrameworkBundle\Fixture\UserContext', $createdBy->getType());
        $this->assertSame('John', $createdBy->getFirstname());
        $this->assertSame('Doe', $createdBy->getLastname());
        $this->assertSame('john@doe.com', $createdBy->getEmail());
    }

    private function ensureUpdatedByFieldChange(bool $isChanged)
    {
        $this
            ->lifecycleEventArgs
            ->expects($this->once())
            ->method('hasChangedField')
            ->with('updatedBy')
            ->will($this->returnValue($isChanged));
    }
}
