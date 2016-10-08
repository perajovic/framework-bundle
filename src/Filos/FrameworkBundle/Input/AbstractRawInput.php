<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Input;

use Filos\FrameworkBundle\Filter\BooleanFilterTrait;
use Filos\FrameworkBundle\Filter\EmailFilterTrait;
use Filos\FrameworkBundle\Filter\PasswordFilterTrait;
use Filos\FrameworkBundle\Filter\ScalarFilterTrait;
use Filos\FrameworkBundle\Filter\StringFilterTrait;

abstract class AbstractRawInput implements RawInputInterface
{
    use BooleanFilterTrait,
        EmailFilterTrait,
        PasswordFilterTrait,
        ScalarFilterTrait,
        StringFilterTrait;
}
