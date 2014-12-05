<?php

namespace Codecontrol\FrameworkBundle\Request;

use Codecontrol\FrameworkBundle\Filter\BooleanFilterTrait;
use Codecontrol\FrameworkBundle\Filter\EmailFilterTrait;
use Codecontrol\FrameworkBundle\Filter\PasswordFilterTrait;
use Codecontrol\FrameworkBundle\Filter\ScalarFilterTrait;
use Codecontrol\FrameworkBundle\Filter\StringFilterTrait;
use Codecontrol\FrameworkBundle\Validator\ValidatorAdapter;
use RuntimeException;

abstract class AppRequest implements AppRequestInterface
{
    use BooleanFilterTrait,
        EmailFilterTrait,
        PasswordFilterTrait,
        ScalarFilterTrait,
        StringFilterTrait;

    /**
     * @var ValidatorAdapter|null
     */
    private $adapter;

    /**
     * @var array
     */
    private $errors;

    /**
     * @param ValidatorAdapter|null $adapter
     */
    public function __construct(ValidatorAdapter $adapter = null)
    {
        $this->adapter = $adapter;
        $this->errors = [];
    }

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        $this->validateFields();

        return empty($this->errors);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * {@inheritDoc}
     */
    public function getFlattenErrors()
    {
        $result = [];

        foreach (array_values($this->errors) as $error) {
            if (!is_array($error)) {
                $result[] = $error;
                continue;
            }

            foreach (array_values($error) as $value) {
                $result[] = $value;
            }
        }

        return implode(PHP_EOL, $result);
    }

    protected function validateFields()
    {
    }

    /**
     * @param string  $field
     * @param array   $constraints
     * @param boolean $isBatchField
     * @param string  $valueKey
     *
     * @throws RuntimeException
     */
    protected function validate(
        $field,
        array $constraints,
        $isBatchField = false,
        $valueKey = null
    ) {
        if (!$this->adapter) {
            return;
        }

        $getterMethod = sprintf('get%s', ucfirst($field));
        if (!method_exists($this, $getterMethod)) {
            throw new RuntimeException(sprintf(
                "Property %s::%s doesn't exist.",
                get_class($this),
                $field
            ));
        }

        $value = $this->{$getterMethod}();

        if (!$isBatchField) {
            $error = $this->adapter->validate($value, $constraints);
            if (null !== $error) {
                $this->errors[$field] = $error;
            }
        } else {
            foreach ($value as $key => $data) {
                $error = $this->adapter->validate(
                    $valueKey ? $data[$valueKey] : $data,
                    $constraints
                );
                if (null !== $error) {
                    $this->errors[$field][$key] = $error;
                }
            }
        }
    }
}
