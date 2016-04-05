<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Filos\FrameworkBundle\Entity;

trait IdentifiableTrait
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int|null $id
     */
    public function setId($id)
    {
        $this->id = $id ? (int) $id : null;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
}
