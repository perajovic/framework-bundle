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

namespace Filos\FrameworkBundle\Tests\Unit\EventListener;

use Filos\FrameworkBundle\EventListener\TruncatableTablesListener;
use Filos\FrameworkBundle\Tests\Fixtures\TruncatableTableEntity;
use Filos\FrameworkBundle\Test\EventListenerTestCase;
use stdClass;

class TruncatableTablesListenerTest extends EventListenerTestCase
{
    private static $getClassMetadataCounter = 0;
    private static $getTableNameCounter = 0;

    /**
     * @test
     */
    public function tableNamesAreCollected()
    {
        $entity1 = new stdClass();
        $entity2 = new TruncatableTableEntity();
        $entity3 = new stdClass();
        $event1 = $this->createLifecycleEventArgs();
        $event2 = $this->createLifecycleEventArgs();
        $event3 = $this->createLifecycleEventArgs();
        $tableName1 = 'foo_table';
        $tableName2 = 'bar_table';
        $tableName3 = 'foo_table';

        $this->ensureEventData($event1, $entity1);
        $this->ensureEventData($event2, $entity2);
        $this->ensureEventData($event3, $entity3);
        $this->ensureClassMetadataInfo($entity1);
        $this->ensureClassMetadataInfo($entity2);
        $this->ensureClassMetadataInfo($entity3);
        $this->ensureTableName($tableName1);
        $this->ensureTableName($tableName2);
        $this->ensureTableName($tableName3);

        $this->listener->postPersist($event1);
        $this->listener->postPersist($event2);
        $this->listener->postPersist($event3);

        $tables = $this->listener->getTables();

        $this->assertSame([$tableName1, $tableName2], $tables);
        $this->assertEmpty($this->listener->getTables());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->classMetadataInfo = $this->createClassMetadataInfo();
        $this->em = $this->createEntityManager();
        $this->listener = new TruncatableTablesListener();
    }

    private function ensureEventData($event, $entity)
    {
        $event
            ->expects($this->once())
            ->method('getEntityManager')
            ->will($this->returnValue($this->em));
        $event
            ->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue($entity));
    }

    private function ensureClassMetadataInfo($entity)
    {
        $this
            ->em
            ->expects($this->at(static::$getClassMetadataCounter++))
            ->method('getClassMetadata')
            ->with(get_class($entity))
            ->will($this->returnValue($this->classMetadataInfo));
    }

    private function ensureTableName($tableName)
    {
        $this
            ->classMetadataInfo
            ->expects($this->at(static::$getTableNameCounter++))
            ->method('getTableName')
            ->will($this->returnValue($tableName));
    }

    private function createLifecycleEventArgs()
    {
        return $this->createMockFor(
            'Doctrine\ORM\Event\LifecycleEventArgs',
            ['getEntityManager', 'getEntity']
        );
    }

    private function createClassMetadataInfo()
    {
        return $this->createMockFor(
            'Doctrine\ORM\Mapping\ClassMetadataInfo',
            ['getTableName']
        );
    }

    private function createEntityManager()
    {
        return $this->createMockFor(
            'Doctrine\ORM\EntityManager',
            ['getClassMetadata']
        );
    }
}
