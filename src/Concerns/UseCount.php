<?php

namespace LukasKleinschmidt\BlockGroups\Concerns;

trait UseCount
{
    protected ?string $count = null;

    public function count(string|int|null $count): static
    {
        if (is_numeric($count)) {
            $count = '{' . $count . '}';
        }

        if (! preg_match('/(\?|\*|\+|{\d+}|{\d+,}|{\d+,\d+})/', $count)) {
            throw new \Exception('Invalid quantifier: ' . $count);
        }

        $this->count = $count;

        return $this;
    }

    public function between(int $min, int $max = null): static
    {
        return $this->count('{' . $min . ',' . $max . '}');
    }

    public function matchesOnce(): bool
    {
        if (is_null($count = $this->count)) {
            return true;
        }

        return (bool) preg_match('/(\?|\{1\}|\{0,1\})$/', $count);
    }

    public function matchesMany(): bool
    {
        return ! $this->matchesOnce();
    }
}
