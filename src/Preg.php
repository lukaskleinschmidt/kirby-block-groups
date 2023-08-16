<?php

namespace LukasKleinschmidt\BlockGroups;

use Kirby\Cms\Blocks;

class Preg
{
    public function __construct(
        protected Blocks &$blocks,
    ) {}

    protected function remove(string $subject, array $matches): string
    {
        $value  = $matches[0][0];
        $offset = $matches[0][1];

        return substr_replace($subject, '', $offset, strlen($value));
    }

    public function subject(): string
    {
        $subject = '';

        // TODO: Add option to extract additional block data

        foreach ($this->blocks as $key => $block) {
            $subject .= $block->type() . ':' . $key . PHP_EOL;
        }

        return $subject;
    }

    public function match(Pattern|string $pattern, bool $exact = false, &$matches = []): bool
    {
        $subject = $this->subject();

        if (! preg_match('/' . $pattern . '/m', $subject, $matches, PREG_OFFSET_CAPTURE)) {
            return false;
        }

        $subject = $this->remove($subject, $matches);

        return $exact ? empty($subject) : true;
    }

    public function matchAll(Pattern|string $pattern, bool $exact = false, &$matches = []): bool
    {
        $subject = $this->subject();

        if (! preg_match_all('/' . $pattern . '/m', $subject, $matches, PREG_OFFSET_CAPTURE)) {
            return false;
        }

        foreach ($matches as $match) {
            $subject = $this->remove($subject, $match);
        }

        return $exact ? empty($subject) : true;
    }
}
