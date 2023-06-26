<?php

declare(strict_types=1);

namespace Codigaco\PhpPayloadValidator;

use Codigaco\PhpPayloadValidator\Exception\PayloadHasViolationsException;

abstract class AbstractPayloadValidator
{
    protected array $payload;
    private array $violations;

    /**
     * @throws PayloadHasViolationsException
     */
    final public function __construct(array $payload)
    {
        $this->violations = [];
        $this->payload = $payload;
        $this->validate();
    }

    abstract protected function payloadConstraints(): array;

    /**
     * @throws PayloadHasViolationsException
     */
    private function validate(): void
    {
        foreach ($this->payloadConstraints() as $field => $fieldConstraints) {
            /** @var AbstractConstraint $fieldConstraint */
            foreach ($fieldConstraints as $fieldConstraint) {
                $violation = $fieldConstraint->validator()->validate(
                    $this->payload[$field] ?? null,
                    $fieldConstraint
                );

                if (null !== $violation) {
                    $this->violations[$field][] = $violation;
                }
            }
        }

        if (empty($this->violations)) {
            return;
        }

        throw new PayloadHasViolationsException($this->violations);
    }

    private function violations(): array
    {
        return $this->violations;
    }
}
