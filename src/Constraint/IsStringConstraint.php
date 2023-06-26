<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator\Constraint;

use Codigaco\PhpPayloadValidator\AbstractConstraint;

class IsStringConstraint extends AbstractConstraint
{
    public function violationMessage(): string
    {
        return $this->message ?? 'Field is not string';
    }
}
