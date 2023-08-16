<?php

namespace LukasKleinschmidt\BlockGroups\Concerns;

trait UseUnlike
{
    protected bool $unlike = false;

    public function unlike(): static
    {
        $this->unlike = true;

        return $this;
    }

    public function like(): static
    {
        $this->unlike = false;

        return $this;
    }
}
