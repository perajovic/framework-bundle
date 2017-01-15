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

use Filos\FrameworkBundle\Utils\ConstantsToArrayResolver;

trait StatusTrait
{
    /**
     * @var string
     */
    private $status;

    public function getStatus(): string
    {
        return $this->status;
    }

    public static function getStatuses(): array
    {
        return (new ConstantsToArrayResolver())->resolve(static::class, 'STATUS');
    }
}
