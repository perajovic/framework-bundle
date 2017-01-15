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

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * @todo Unit test is missing
 */
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

    public function postPersist(LifecycleEventArgs $event)
    {
        $table = $event
            ->getEntityManager()
            ->getClassMetadata(get_class($event->getEntity()))
            ->getTableName();

        if (!in_array($table, $this->tables, true)) {
            $this->tables[] = $table;
        }
    }

    public function getTables(): array
    {
        $tables = $this->tables;

        // reset array regarding to possible side effects
        $this->tables = [];

        return $tables;
    }
}
