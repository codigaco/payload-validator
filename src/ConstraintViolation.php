<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator;

class ConstraintViolation
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function message(): string
    {
        return $this->message;
    }
}
