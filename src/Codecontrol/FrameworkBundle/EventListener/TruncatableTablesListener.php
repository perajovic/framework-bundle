<?php

namespace Codecontrol\FrameworkBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

class TruncatableTablesListener
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
