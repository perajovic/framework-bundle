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

namespace Filos\FrameworkBundle\Input;

use Filos\FrameworkBundle\Filter\BooleanFilterTrait;
use Filos\FrameworkBundle\Filter\EmailFilterTrait;
use Filos\FrameworkBundle\Filter\PasswordFilterTrait;
use Filos\FrameworkBundle\Filter\ScalarFilterTrait;
use Filos\FrameworkBundle\Filter\StringFilterTrait;

abstract class RawInput implements RawInputInterface
{
    use BooleanFilterTrait,
        EmailFilterTrait,
        PasswordFilterTrait,
        ScalarFilterTrait,
        StringFilterTrait;
}
