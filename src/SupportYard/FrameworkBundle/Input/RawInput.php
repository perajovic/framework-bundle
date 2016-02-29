<?php

namespace SupportYard\FrameworkBundle\Input;

use SupportYard\FrameworkBundle\Filter\BooleanFilterTrait;
use SupportYard\FrameworkBundle\Filter\EmailFilterTrait;
use SupportYard\FrameworkBundle\Filter\PasswordFilterTrait;
use SupportYard\FrameworkBundle\Filter\ScalarFilterTrait;
use SupportYard\FrameworkBundle\Filter\StringFilterTrait;

abstract class RawInput implements RawInputInterface
{
    use BooleanFilterTrait,
        EmailFilterTrait,
        PasswordFilterTrait,
        ScalarFilterTrait,
        StringFilterTrait;
}
