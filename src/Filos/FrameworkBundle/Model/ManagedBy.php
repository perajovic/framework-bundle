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
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $exists;

    /**
     * @var string|null
     */
    private $firstname;

    /**
     * @var string|null
     */
    private $lastname;

    /**
     * @var string
     */
    private $email;

    private function __construct()
    {
    }

    /**
     * @param Uuid        $id
     * @param string      $type
     * @param string      $email
     * @param null|string $firstname
     * @param null|string $lastname
     *
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
     * @param string      $email
     * @param null|string $firstname
     * @param null|string $lastname
     */
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

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isExists(): bool
    {
        return $this->exists;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
