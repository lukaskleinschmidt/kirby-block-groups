<?php

namespace LukasKleinschmidt\BlockGroups\Contracts;

interface Matches
{
    public function matchesOnce(): bool;

    public function matchesMany(): bool;
}
