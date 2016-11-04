<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model;

use DateTime;

trait CreatableTrait
{
    /**
     * @var ManagedBy|null
     */
    private $createdBy;

    /**
     * @var DateTime|null
     */
    private $createdAt;

    /**
     * @param ManagedBy $createdBy
     */
    public function setCreatedBy(ManagedBy $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return ManagedBy|null
     */
    public function getCreatedBy(): ?ManagedBy
    {
        return $this->createdBy;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
}
