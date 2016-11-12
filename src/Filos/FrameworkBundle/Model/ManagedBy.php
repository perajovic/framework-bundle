<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model;

class ManagedBy
{
    /**
     * @var Uuid
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $exists;

    /**
     * @var string|null
     */
    protected $firstname;

    /**
     * @var string|null
     */
    protected $lastname;

    /**
     * @var string
     */
    protected $email;

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function create(
        Uuid $id,
        string $type,
        string $email,
        ?string $firstname = null,
        ?string $lastname = null
    ) {
        $managedBy = new static();
        $managedBy->id = $id;
        $managedBy->type = $type;
        $managedBy->email = $email;
        $managedBy->firstname = $firstname;
        $managedBy->lastname = $lastname;
        $managedBy->exists = true;

        return $managedBy;
    }

    /**
     * @todo
     *
     * This method signature should be compatible with 7.1 nullable types `?string $firstname, ?string $lastname`.
     * ATM (12.11.2016.) there are bugs in two projects:
     * 1. https://github.com/zendframework/zend-code/issues/85
     * 2. https://github.com/Ocramius/ProxyManager/pull/327
     *
     * They are blockers for 7.1 syntax.
     */
    public function update(string $email, string $firstname = null, string $lastname = null)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function notExists()
    {
        $this->exists = false;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isExists(): bool
    {
        return $this->exists;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
