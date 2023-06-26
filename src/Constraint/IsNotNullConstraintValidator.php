<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator\Constraint;

use Codigaco\PhpPayloadValidator\AbstractConstraintValidator;
use Codigaco\PhpPayloadValidator\ConstraintViolation;

class IsNotNullConstraintValidator extends AbstractConstraintValidator
{
    public function validate($value, IsNotNullConstraint $constraint): ?ConstraintViolation
    {
        if ($value !== null) {
            return null;
        }

        return new ConstraintViolation($constraint->violationMessage());
    }
}
