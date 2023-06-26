<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator;

abstract class AbstractConstraint
{
    protected ?string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message;
    }

    public function validator(): AbstractConstraintValidator
    {
        $constraintValidatorClass = static::class . 'Validator';
        return new $constraintValidatorClass;
    }

    abstract public function violationMessage(): string;
}
