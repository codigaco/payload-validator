<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator\Constraint;

use Codigaco\PhpPayloadValidator\AbstractConstraint;

class IsNotNullConstraint extends AbstractConstraint
{
    public function violationMessage(): string
    {
        return $this->message ?? 'Field is null';
    }
}
