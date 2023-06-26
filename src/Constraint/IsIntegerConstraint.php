<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator\Constraint;

use Codigaco\PhpPayloadValidator\AbstractConstraint;

class IsIntegerConstraint extends AbstractConstraint
{
    public function violationMessage(): string
    {
        return $this->message ?? 'Field is not integer';
    }
}
