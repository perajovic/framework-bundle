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
use Filos\FrameworkBundle\Model\Attribute\Uuid;
use Filos\FrameworkBundle\Model\ModelModifier;
use Filos\FrameworkBundle\RequestContext\UserContextInterface;

trait ModelModifierTrait
{
    /**
     * @var array
     */
    private $cache = [];

    private function createModelModifierFromUserContext(LifecycleEventArgs $args, UserContextInterface $userContext): ModelModifier
    {
        $modifier = ModelModifier::create(
            $userContext->getId(),
            get_class($userContext),
            $userContext->getEmail(),
            $userContext->getFirstname(),
            $userContext->getLastname()
        );

        $args->getObjectManager()->persist($modifier);

        $this->cache[$this->getCacheKey($modifier->getId(), $modifier->getType())] = $modifier;

        return $modifier;
    }

    private function findModelModifier(LifecycleEventArgs $args, UserContextInterface $userContext): ?ModelModifier
    {
        $key = $this->getCacheKey($userContext->getId(), get_class($userContext));
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $result = $args
            ->getObjectManager()
            ->getRepository(ModelModifier::class)
            ->findBy([
                'id' => $userContext->getId(),
                'type' => get_class($userContext),
            ]);

        if (!isset($result[0])) {
            return null;
        }

        /** @var ModelModifier $modifier */
        $modifier = $result[0];

        $this->cache[$key] = $modifier;

        return $modifier;
    }

    private function getCacheKey(Uuid $id, string $type): string
    {
        return (string) $id.'-'.$type;
    }
}
