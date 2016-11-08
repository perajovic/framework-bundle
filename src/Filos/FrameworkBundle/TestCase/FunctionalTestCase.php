<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\TestCase;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use LogicException;

abstract class FunctionalTestCase extends WebTestCase
{
    use TestCaseTrait;

    protected function setUp()
    {
        parent::setUp();

        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    protected function tearDown()
    {
        $this->truncateTables();
        $this->nullifyProperties();

        parent::tearDown();

        static::$kernel = null;
    }

    /**
     * @param string $id
     *
     * @return object
     */
    protected function getService($id)
    {
        return static::$kernel->getContainer()->get($id);
    }

    /**
     * @return EntityManagerInterface
     *
     * @throws LogicException
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        if (!static::$kernel->getContainer()->has('doctrine')) {
            throw new LogicException(
                'The DoctrineBundle is not registered in your application.'
            );
        }

        $emId = !defined('static::EM_ID') ? 'default' : static::EM_ID;

        return $this->getService('doctrine')->getManager($emId);
    }

    private function truncateTables()
    {
        $container = static::$kernel->getContainer();
        if (!$container->has('filos_framework.listener.truncatable_tables')) {
            return;
        }

        $tables = $container
            ->get('filos_framework.listener.truncatable_tables')
            ->getTables();

        if (empty($tables)) {
            return;
        }

        $connection = $this->getEntityManager()->getConnection();

        if ('postgresql' !== $connection->getDatabasePlatform()->getName()) {
            return;
        }

        foreach ($tables as $table) {
            $connection->exec(sprintf('TRUNCATE %s CASCADE', $table));
        }
    }
}
