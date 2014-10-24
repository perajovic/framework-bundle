<?php

namespace Codecontrol\FrameworkBundle\Validator;

use Symfony\Component\Validator\ValidatorInterface;

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
     * @see Symfony\Component\Validator\ValidatorInterface::validate
     *
     * @return array
     */
    public function validate(
        $value,
        $groups = null,
        $traverse = false,
        $deep = false
    ) {
        $errors = [];
        $result = $this->validator->validate($value, $groups, $traverse, $deep);

        $cnt = count($result);
        for ($i = 0; $i < $cnt; $i++) {
            $errors[$result[$i]->getPropertyPath()] = $result[$i]->getMessage();
        }

        return $errors;
    }

    /**
     * @param string $value
     * @param array  $constraints
     *
     * @return string|null
     */
    public function validateValue($value, array $constraints)
    {
        $result = $this->validator->validateValue($value, $constraints);

        return 0 === count($result) ? null : $result[0]->getMessage();
    }
}
