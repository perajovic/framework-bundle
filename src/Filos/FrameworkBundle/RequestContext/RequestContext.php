<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\RequestContext;

final class RequestContext
{
    /**
     * @var AccountContextInterface|null
     */
    private $account;

    /**
     * @var UserContextInterface|null
     */
    private $user;

    public function setUser(UserContextInterface $user)
    {
        $this->user = $user;
    }

    public function getUser(): ?UserContextInterface
    {
        return $this->user;
    }

    public function resolveUserId(): ?string
    {
        $user = $this->getUser();

        return $user ? $user->getId()->get() : null;
    }

    public function setAccount(AccountContextInterface $account)
    {
        $this->account = $account;
    }

    public function getAccount(): ?AccountContextInterface
    {
        return $this->account;
    }

    public function resolveAccountId(): ?string
    {
        $account = $this->getAccount();

        return $account ? $account->getId()->get() : null;
    }
}
