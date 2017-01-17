<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model\Attribute;

use DateTime;
use Filos\FrameworkBundle\Model\ModelModifier;

trait UpdatableTrait
{
    /**
     * @var ModelModifier|null
     */
    private $updatedBy;

    /**
     * @var DateTime|null
     */
    private $updatedAt;

    public function setUpdatedBy(ModelModifier $updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedBy(): ?ModelModifier
    {
        return $this->updatedBy;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }
}
