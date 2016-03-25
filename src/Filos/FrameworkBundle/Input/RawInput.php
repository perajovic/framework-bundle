<?php

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
