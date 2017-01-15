<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Filos\FrameworkBundle\RequestContext\UserContextInterface;

/**
 * Configuration example.
 *
 *  listener.make_managed_by_non_existing:
 *      class: 'Filos\FrameworkBundle\EventListener\MakeManagedByNonExistingListener'
 *      tags:
 *          - { name: 'doctrine.event_listener', event: 'preRemove' }
 */
final class MakeManagedByNonExistingListener
{
    use ManagedByTrait;

    public function preRemove(LifecycleEventArgs $args)
    {
        /** @var UserContextInterface $entity */
        $entity = $args->getObject();

        if (!$entity instanceof UserContextInterface) {
            return;
        }

        $managedBy = $this->findManagedBy($args, $entity);

        if ($managedBy) {
            $managedBy->markAsNonExisting();
        }
    }
}
