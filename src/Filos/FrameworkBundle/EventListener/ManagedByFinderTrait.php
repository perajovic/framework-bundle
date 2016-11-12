<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Filos\FrameworkBundle\Model\ManagedBy;
use Filos\FrameworkBundle\RequestContext\UserContextInterface;

trait ManagedByFinderTrait
{
    protected function findManagedBy(LifecycleEventArgs $args, UserContextInterface $userContext): ?ManagedBy
    {
        $result = $args
            ->getObjectManager()
            ->getRepository(ManagedBy::class)
            ->findBy([
                'id' => $userContext->getId(),
                'type' => get_class($userContext),
            ]);

        return $result[0] ?? null;
    }
}
