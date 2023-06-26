<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator\Constraint;


use Codigaco\PhpPayloadValidator\AbstractConstraintValidator;
use Codigaco\PhpPayloadValidator\ConstraintViolation;

class IsNotBlankConstraintValidator extends AbstractConstraintValidator
{
    public function validate($value, IsNotBlankConstraint $constraint): ?ConstraintViolation
    {
        if (null === $value) {
            return null;
        }

        if (!is_string($value)) {
            return null;
        }

        if (!empty($value)) {
            return null;
        }

        return new ConstraintViolation($constraint->violationMessage());
    }
}
