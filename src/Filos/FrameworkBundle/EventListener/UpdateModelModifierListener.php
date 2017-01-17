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
 *  listener.update_model_modifier:
 *      class: 'Filos\FrameworkBundle\EventListener\UpdateModelModifierListener'
 *      tags:
 *          - { name: 'doctrine.event_listener', event: 'postUpdate' }
 */
final class UpdateModelModifierListener
{
    use ModelModifierTrait;

    public function postUpdate(LifecycleEventArgs $args)
    {
        /** @var UserContextInterface $entity */
        $entity = $args->getObject();

        if (!$entity instanceof UserContextInterface) {
            return;
        }

        $modifier = $this->findModelModifier($args, $entity);

        if ($modifier) {
            $modifier->update($entity->getEmail(), $entity->getFirstname(), $entity->getLastname());
            $args->getObjectManager()->flush();
        }
    }
}
