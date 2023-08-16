<?php

namespace LukasKleinschmidt\BlockGroups\Concerns;

trait UsePosition
{
    protected ?string $start = null;

    protected ?string $end = null;

    public function start(bool $start = true): static
    {
        $this->start = $start ? '\A' : '';

        return $this;
    }

    public function end(bool $end = true): static
    {
        $this->end = $end ? '\Z' : '';

        return $this;
    }
}
