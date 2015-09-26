<?php

namespace SupportYard\FrameworkBundle\Validator\Constraints;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class VirusValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!function_exists('cl_scanfile')) {
            return;
        }

        if (!($value instanceof UploadedFile)) {
            return;
        }

        $file = $value->getPathname();

        if (!is_file($file)) {
            return;
        }

        $retcode = cl_scanfile($file, $virusName);

        if ($retcode != CL_VIRUS) {
            return;
        }

        $this->context->addViolation($constraint->message);
    }
}
