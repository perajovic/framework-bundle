<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Entity;

use DateTime;

final class Updated
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
