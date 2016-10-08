<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Entity;

use DateTime;

final class Created
{
    /**
     * @var ByInterface|null
     */
    private $by;

    /**
     * @var DateTime|null
     */
    private $at;

    /**
     * @param ByInterface|null $by
     * @param DateTime|null    $at
     */
    public function __construct(ByInterface $by = null, DateTime $at = null)
    {
        $this->by = $by;
        $this->at = $at;
    }

    /**
     * @return ByInterface|null
     */
    public function getBy()
    {
        return $this->by;
    }

    /**
     * @return DateTime|null
     */
    public function getAt()
    {
        return $this->at;
    }
}
