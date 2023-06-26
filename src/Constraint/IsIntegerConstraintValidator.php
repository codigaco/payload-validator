<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator\Constraint;

use Codigaco\PhpPayloadValidator\AbstractConstraintValidator;
use Codigaco\PhpPayloadValidator\ConstraintViolation;

class IsIntegerConstraintValidator extends AbstractConstraintValidator
{
    public function validate($value, IsIntegerConstraint $constraint): ?ConstraintViolation
    {
        if (null === $value){
            return null;
        }

        if (is_int($value)) {
            return null;
        }

        return new ConstraintViolation($constraint->violationMessage());
    }
}
