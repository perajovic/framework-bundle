<?php

namespace Codecontrol\FrameworkBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Virus extends Constraint
{
    public $message = 'This file contains a virus.';
}
