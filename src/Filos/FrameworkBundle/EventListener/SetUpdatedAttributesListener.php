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
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Filos\FrameworkBundle\Model\Attribute\UpdatableTrait;
use Filos\FrameworkBundle\Model\ModelModifier;
use Filos\FrameworkBundle\RequestContext\RequestContext;

/**
 * Configuration example.
 *
 *  listener.set_updated_attributes:
 *      class: 'Filos\FrameworkBundle\EventListener\SetUpdatedAttributesListener'
 *      tags:
 *          - { name: 'doctrine.event_listener', event: 'preUpdate' }
 */
final class SetUpdatedAttributesListener
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

    public function preUpdate(PreUpdateEventArgs $args)
    {
        /** @var UpdatableTrait $entity */
        $entity = $args->getObject();

        if (!$this->isUpdatableInstance($entity)) {
            return;
        }

        if (null === $entity->getUpdatedAt()) {
            $entity->setUpdatedAt(new DateTime('now'));
        }

        $user = $this->requestContext->getUser();

        if ($user && !$args->hasChangedField('updatedBy')) {
            /** @var ModelModifier $modifier */
            $modifier = $this->findModelModifier($args, $user);

            if (!$modifier) {
                $modifier = $this->createModelModifierFromUserContext($args, $user);
            }

            $entity->setUpdatedBy($modifier);
        }
    }

    /**
     * @param object $entity
     */
    private function isUpdatableInstance($entity): bool
    {
        return in_array(UpdatableTrait::class, class_uses(get_class($entity), false), true);
    }
}
