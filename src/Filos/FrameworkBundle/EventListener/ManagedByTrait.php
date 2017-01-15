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
use Filos\FrameworkBundle\Model\ManagedBy;
use Filos\FrameworkBundle\RequestContext\UserContextInterface;

trait ManagedByTrait
{
    /**
     * @var array
     */
    private $cache = [];

    private function createManagedByFromUserContext(LifecycleEventArgs $args, UserContextInterface $userContext): ManagedBy
    {
        $managedBy = ManagedBy::create(
            $userContext->getId(),
            get_class($userContext),
            $userContext->getEmail(),
            $userContext->getFirstname(),
            $userContext->getLastname()
        );

        $args->getObjectManager()->persist($managedBy);

        $this->cache[$this->getCacheKey($managedBy->getId(), $managedBy->getType())] = $managedBy;

        return $managedBy;
    }

    private function findManagedBy(LifecycleEventArgs $args, UserContextInterface $userContext): ?ManagedBy
    {
        $key = $this->getCacheKey($userContext->getId(), get_class($userContext));
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $result = $args
            ->getObjectManager()
            ->getRepository(ManagedBy::class)
            ->findBy([
                'id' => $userContext->getId(),
                'type' => get_class($userContext),
            ]);

        if (!isset($result[0])) {
            return null;
        }

        /** @var ManagedBy $managedBy */
        $managedBy = $result[0];

        $this->cache[$key] = $managedBy;

        return $managedBy;
    }

    private function getCacheKey(Uuid $id, string $type): string
    {
        return (string) $id.'-'.$type;
    }
}
