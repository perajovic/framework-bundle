<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Filos\FrameworkBundle\RequestContext\UserContextInterface;

/**
 * Configuration example.
 *
 *  listener.update_managed_by_info:
 *      class: 'Filos\FrameworkBundle\EventListener\UpdateManagedByInfoListener'
 *      tags:
 *          - { name: 'doctrine.event_listener', event: 'postUpdate' }
 */
final class UpdateManagedByInfoListener
{
    use ManagedByFinderTrait;

    public function postUpdate(LifecycleEventArgs $args)
    {
        /** @var UserContextInterface $entity */
        $entity = $args->getObject();

        if (!$entity instanceof UserContextInterface) {
            return;
        }

        $managedBy = $this->findManagedBy($args, $entity);

        if ($managedBy) {
            $managedBy->update($entity->getEmail(), $entity->getFirstname(), $entity->getLastname());
            $args->getObjectManager()->flush();
        }
    }
}
