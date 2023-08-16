<?php

namespace LukasKleinschmidt\BlockGroups;

use Stringable;

class Pattern implements Stringable
{
    public function __construct(
        protected string $value,
    ) {}

    public static function from(Pattern|array|string $value): self
    {
        if ($value instanceof Pattern) {
            return $value;
        }

        if (is_array($value)) {
            $value = implode('', $value);
        }

        return new self($value);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
