<?php

namespace Codecontrol\FrameworkBundle\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorAdapter
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @see ValidatorInterface::validate
     *
     * @param mixed                   $value
     * @param Constraint|Constraint[] $constraints
     * @param array|null              $groups
     *
     * @return string|null
     */
    public function validate($value, $constraints = null, $groups = null)
    {
        $result = $this->validator->validate($value, $constraints, $groups);

        return 0 === count($result) ? null : $result[0]->getMessage();
    }
}
