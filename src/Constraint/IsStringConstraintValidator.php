<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator\Constraint;

use Codigaco\PhpPayloadValidator\AbstractConstraintValidator;
use Codigaco\PhpPayloadValidator\ConstraintViolation;

class IsStringConstraintValidator extends AbstractConstraintValidator
{
    public function validate($value, IsStringConstraint $constraint): ?ConstraintViolation
    {
        if (null === $value) {
            return null;
        }

        if (is_string($value)) {
            return null;
        }

        return new ConstraintViolation($constraint->violationMessage());
    }
}
