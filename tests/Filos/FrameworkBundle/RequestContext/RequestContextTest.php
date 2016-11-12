<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle;

use Filos\FrameworkBundle\RequestContext\RequestContext;
use Filos\FrameworkBundle\TestCase\TestCase;
use Tests\Filos\FrameworkBundle\Fixture\AccountContext;
use Tests\Filos\FrameworkBundle\Fixture\UserContext;

class RequestContextTest extends TestCase
{
    /**
     * @var RequestContext
     */
    private $requestContext;

    protected function setUp()
    {
        parent::setUp();

        $this->requestContext = new RequestContext();
    }

    /**
     * @test
     */
    public function checkInitalState()
    {
        $this->assertNull($this->requestContext->getAccount());
        $this->assertNull($this->requestContext->getUser());
        $this->assertNull($this->requestContext->resolveUserId());
        $this->assertNull($this->requestContext->resolveAccountId());
    }

    /**
     * @test
     */
    public function currentAccountIsSettledAndRetrieved()
    {
        $account = new AccountContext();

        $this->requestContext->setAccount($account);

        $this->assertSame($account, $this->requestContext->getAccount());
        $this->assertSame('efg-abc-123', $this->requestContext->resolveAccountId());
    }

    /**
     * @test
     */
    public function currentUserIsSettledAndRetrieved()
    {
        $user = new UserContext();

        $this->requestContext->setUser($user);

        $this->assertSame($user, $this->requestContext->getUser());
        $this->assertSame('123-abc-efg', $this->requestContext->resolveUserId());
    }
}
