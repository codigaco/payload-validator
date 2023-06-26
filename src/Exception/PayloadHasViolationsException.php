<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator\Exception;

use Codigaco\PhpPayloadValidator\ConstraintViolation;
use Exception;

class PayloadHasViolationsException extends Exception
{
    private array $violations;

    public function __construct(array $violations)
    {
        parent::__construct('The request has violations');
        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolation[][]
     */
    public function violations(): array
    {
        return $this->violations;
    }
}
