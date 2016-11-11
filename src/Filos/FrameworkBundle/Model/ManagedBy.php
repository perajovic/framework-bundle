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

    public function update(string $email, ?string $firstname, ?string $lastname)
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
