<?php

namespace LukasKleinschmidt\BlockGroups;

class BlockPattern extends Pattern implements Contracts\Matches
{
    use Concerns\UseCount,
        Concerns\UsePosition,
        Concerns\UseUnlike;

    protected ?string $type = null;

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function toString(): string
    {
        $values = [
            '[V]' => $this->unlike
                ? '(?!' . $this->value . ')'
                : '(?:' . $this->value . ')',
            '[T]' => $this->type,
            '[C]' => $this->count,
            '[S]' => $this->start,
            '[E]' => $this->end,
        ];

        return str_replace(array_keys($values), $values, $this->type
            ? '[S]^(?\'[T]\'(?:[V]\b(?:.{36}).*\n)[C])[E]'
            : '[S]^((?:[V]\b(?:.{36}).*\n)[C])[E]'
        );
    }
}
