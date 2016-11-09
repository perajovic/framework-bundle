<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle;

use Filos\FrameworkBundle\Model\CurrentAccountInterface;
use Filos\FrameworkBundle\Model\CurrentUserInterface;

class RequestContext
{
    /**
     * @var CurrentAccountInterface|null
     */
    private $account;

    /**
     * @var CurrentUserInterface|null
     */
    private $user;

    /**
     * @param CurrentUserInterface $user
     */
    public function setUser(CurrentUserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return CurrentUserInterface|null
     */
    public function getUser(): ?CurrentUserInterface
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function resolveUserId(): ?string
    {
        $user = $this->getUser();

        return $user ? $user->getId()->get() : null;
    }

    /**
     * @param CurrentAccountInterface $account
     */
    public function setAccount(CurrentAccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * @return CurrentAccountInterface|null
     */
    public function getAccount(): ?CurrentAccountInterface
    {
        return $this->account;
    }

    /**
     * @return string|null
     */
    public function resolveAccountId(): ?string
    {
        $account = $this->getAccount();

        return $account ? $account->getId()->get() : null;
    }
}
