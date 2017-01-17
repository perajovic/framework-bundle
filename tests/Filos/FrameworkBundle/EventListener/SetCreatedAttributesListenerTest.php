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
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Filos\FrameworkBundle\EventListener\SetCreatedAttributesListener;
use Filos\FrameworkBundle\Model\Attribute\Uuid;
use Filos\FrameworkBundle\Model\ModelModifier;
use Filos\FrameworkBundle\RequestContext\RequestContext;
use stdClass;
use Tests\Filos\FrameworkBundle\Fixture\CreatableEntity;
use Tests\Filos\FrameworkBundle\Fixture\UserContext;
use Tests\Filos\FrameworkBundle\TestCase\DoctrineListenerTestCase;

class SetCreatedAttributesListenerTest extends DoctrineListenerTestCase
{
    /**
     * @var SetCreatedAttributesListener
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
     * @var CreatableEntity
     */
    private $creatableEntity;

    /**
     * @var ModelModifier
     */
    private $modifier;

    protected function setUp()
    {
        parent::setUp();

        $this->requestContext = new RequestContext();
        $this->userContext = new UserContext();
        $this->creatableEntity = new CreatableEntity();
        $this->modifier = ModelModifier::create(new Uuid('111-222-aaa'), 'Some\Type', 'j@doe.com');
        $this->listener = new SetCreatedAttributesListener($this->requestContext);
    }

    /**
     * @test
     */
    public function ifEntityIsNotCreatableTraitInstanceExecutionIsSkipped()
    {
        $this->ensureObject(new stdClass());
        $this->ensureObjectManagerIsNotCalled();

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->prePersist($this->lifecycleEventArgs);
    }

    /**
     * @test
     */
    public function ifCreatedAtIsNotSettledNewDateTimeWillBeSet()
    {
        $this->ensureObject($this->creatableEntity);
        $this->ensureObjectManagerIsNotCalled();

        $this->assertNull($this->creatableEntity->getCreatedAt());

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->prePersist($this->lifecycleEventArgs);

        $this->assertInstanceOf(DateTime::class, $this->creatableEntity->getCreatedAt());
    }

    /**
     * @test
     */
    public function ifCreatedAtIsSettledNewDateTimeWillNotBeSet()
    {
        $date = new DateTime('now');
        $this->creatableEntity->setCreatedAt($date);

        $this->ensureObject($this->creatableEntity);
        $this->ensureObjectManagerIsNotCalled();

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->prePersist($this->lifecycleEventArgs);

        $this->assertSame($date, $this->creatableEntity->getCreatedAt());
    }

    /**
     * @test
     */
    public function ifCreatedByIsSettledNewCreatedByWillNotBeSet()
    {
        $this->creatableEntity->setCreatedBy($this->modifier);
        $this->requestContext->setUser($this->userContext);

        $this->ensureObject($this->creatableEntity);
        $this->ensureObjectManagerIsNotCalled();

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->prePersist($this->lifecycleEventArgs);

        $this->assertSame($this->modifier, $this->creatableEntity->getCreatedBy());
    }

    /**
     * @test
     */
    public function ifUserContextDoesNotExistNewCreatedByWillNotBeSet()
    {
        $this->ensureObject($this->creatableEntity);
        $this->ensureObjectManagerIsNotCalled();

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->prePersist($this->lifecycleEventArgs);

        $this->assertNull($this->creatableEntity->getCreatedBy());
    }

    /**
     * @test
     */
    public function existingModelModifierIsSettled()
    {
        $this->requestContext->setUser($this->userContext);

        $this->ensureObject($this->creatableEntity);
        $this->ensureModelModifierResult($this->modifier, $this->userContext);

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->prePersist($this->lifecycleEventArgs);

        $this->assertSame($this->modifier, $this->creatableEntity->getCreatedBy());
    }

    /**
     * @test
     */
    public function newModelModifierIsCreatedAndSettled()
    {
        $this->requestContext->setUser($this->userContext);

        $this->ensureObject($this->creatableEntity);
        $this->ensureModelModifierResult(null, $this->userContext);
        $this->ensureModelModifierIsPersisted();

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->prePersist($this->lifecycleEventArgs);

        $createdBy = $this->creatableEntity->getCreatedBy();

        $this->assertSame('123-abc-efg', $createdBy->getId()->get());
        $this->assertSame('Tests\Filos\FrameworkBundle\Fixture\UserContext', $createdBy->getType());
        $this->assertSame('John', $createdBy->getFirstname());
        $this->assertSame('Doe', $createdBy->getLastname());
        $this->assertSame('john@doe.com', $createdBy->getEmail());
    }
}
