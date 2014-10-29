<?php

namespace Codecontrol\FrameworkBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \LogicException as LogicException;
use \RuntimeException as RuntimeException;

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
     * @return Doctrine\ORM\EntityManagerInterface
     *
     * @throws LogicException
     * @throws RuntimeException
     */
    protected function getEntityManager()
    {
        if (!static::$kernel->getContainer()->has('doctrine')) {
            throw new LogicException(
                'The DoctrineBundle is not registered in your application.'
            );
        }

        if (!defined('static::EM_ID')) {
            throw new RuntimeException(sprintf(
                'Constant %s::EM_ID is not defined.',
                get_class($this)
            ));
        }

        return $this->getService('doctrine')->getManager(static::EM_ID);
    }

    private function truncateTables()
    {
        $container = static::$kernel->getContainer();
        if (!$container->has('codecontrol_framework.listener.truncatable_tables')) {
            return;
        }

        $tables = $container
            ->get('codecontrol_framework.listener.truncatable_tables')
            ->getTables();

        if (empty($tables)) {
            return;
        }

        $connection = $this->getEntityManager()->getConnection();

        if ($connection->getDatabasePlatform()->getName() !== 'postgresql') {
            return;
        }

        foreach ($tables as $table) {
            $connection->exec(sprintf('TRUNCATE %s CASCADE', $table));
            $connection->exec(sprintf(
                'ALTER SEQUENCE %s_id_seq RESTART WITH 1',
                $table
            ));
        }
    }
}
