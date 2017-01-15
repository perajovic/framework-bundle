<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\TestCase;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
     * @return object
     */
    protected function getService(string $id)
    {
        return static::$kernel->getContainer()->get($id);
    }

    /**
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
