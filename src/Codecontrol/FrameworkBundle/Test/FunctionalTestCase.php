<?php

namespace Codecontrol\FrameworkBundle\Test;

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
}
