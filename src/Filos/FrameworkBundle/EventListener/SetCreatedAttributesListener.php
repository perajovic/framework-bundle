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

use DateTime;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Filos\FrameworkBundle\Model\Attribute\CreatableTrait;
use Filos\FrameworkBundle\Model\ModelModifier;
use Filos\FrameworkBundle\RequestContext\RequestContext;

/**
 * Configuration example.
 *
 *  listener.set_created_attributes:
 *      class: 'Filos\FrameworkBundle\EventListener\SetCreatedAttributesListener'
 *      tags:
 *          - { name: 'doctrine.event_listener', event: 'prePersist' }
 */
final class SetCreatedAttributesListener
{
    use ModelModifierTrait;

    /**
     * @var RequestContext
     */
    private $requestContext;

    public function __construct(RequestContext $requestContext)
    {
        $this->requestContext = $requestContext;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var CreatableTrait $entity */
        $entity = $args->getObject();

        if (!$this->isCreatableInstance($entity)) {
            return;
        }

        if (null === $entity->getCreatedAt()) {
            $entity->setCreatedAt(new DateTime('now'));
        }

        $user = $this->requestContext->getUser();

        if ($user && null === $entity->getCreatedBy()) {
            /** @var ModelModifier $modifier */
            $modifier = $this->findModelModifier($args, $user);

            if (!$modifier) {
                $modifier = $this->createModelModifierFromUserContext($args, $user);
            }

            $entity->setCreatedBy($modifier);
        }
    }

    /**
     * @param object $entity
     */
    private function isCreatableInstance($entity): bool
    {
        return in_array(CreatableTrait::class, class_uses(get_class($entity), false), true);
    }
}
