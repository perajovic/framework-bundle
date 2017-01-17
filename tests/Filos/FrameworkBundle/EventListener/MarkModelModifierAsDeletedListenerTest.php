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
use Filos\FrameworkBundle\EventListener\MarkModelModifierAsDeletedListener;
use Filos\FrameworkBundle\Model\Attribute\Uuid;
use Filos\FrameworkBundle\Model\ModelModifier;
use stdClass;
use Tests\Filos\FrameworkBundle\Fixture\UserContext;
use Tests\Filos\FrameworkBundle\TestCase\DoctrineListenerTestCase;

class MarkModelModifierAsDeletedListenerTest extends DoctrineListenerTestCase
{
    /**
     * @var MarkModelModifierAsDeletedListener
     */
    private $listener;

    /**
     * @var UserContext
     */
    private $userContext;

    /**
     * @var ModelModifier
     */
    private $modifier;

    protected function setUp()
    {
        parent::setUp();

        $this->listener = new MarkModelModifierAsDeletedListener();
        $this->userContext = new UserContext();
        $this->modifier = ModelModifier::create(new Uuid(), 'Some\Type', 'john@doe.com');
    }

    /**
     * @test
     */
    public function ifEntityIsNotUserContextInstanceExecutionIsSkipped()
    {
        $this->ensureObject(new stdClass());

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->preRemove($this->lifecycleEventArgs);
    }

    /**
     * @test
     */
    public function modifierIsNotMarkedAsDeletedWhenItIsNotFound()
    {
        $this->ensureObject($this->userContext);
        $this->ensureModelModifierResult(null, $this->userContext);

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->preRemove($this->lifecycleEventArgs);
    }

    /**
     * @test
     */
    public function modifierIsMarkedAsDeletedWhenItIsFound()
    {
        $this->ensureObject($this->userContext);
        $this->ensureModelModifierResult($this->modifier, $this->userContext);

        /* @var LifecycleEventArgs $this->lifecycleEventArgs */
        $this->listener->preRemove($this->lifecycleEventArgs);

        $this->assertFalse($this->modifier->isDeleted());
    }
}
