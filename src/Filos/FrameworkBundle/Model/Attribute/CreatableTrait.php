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

trait CreatableTrait
{
    /**
     * @var ModelModifier|null
     */
    private $createdBy;

    /**
     * @var DateTime|null
     */
    private $createdAt;

    public function setCreatedBy(ModelModifier $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedBy(): ?ModelModifier
    {
        return $this->createdBy;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
}
