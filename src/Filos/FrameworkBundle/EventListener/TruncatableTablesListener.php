<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Filos\FrameworkBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

final class TruncatableTablesListener
{
    /**
     * @var array
     */
    private $tables;

    public function __construct()
    {
        $this->tables = [];
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $table = $event
            ->getEntityManager()
            ->getClassMetadata(get_class($event->getEntity()))
            ->getTableName();

        if (in_array($table, $this->tables)) {
            return;
        }

        $this->tables[] = $table;
    }

    /**
     * @return array
     */
    public function getTables()
    {
        $tables = $this->tables;

        // reset array regarding to possible side effects
        $this->tables = [];

        return $tables;
    }
}
