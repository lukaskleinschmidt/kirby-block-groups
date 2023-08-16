<?php

namespace LukasKleinschmidt\BlockGroups;

use Closure;

class Group
{
    protected array $pattern;

    protected Closure|string|null $render;

    public function __construct(array $pattern, Closure|string|null $render = null)
    {
        foreach ($pattern as $key => $value) {
            if (is_string($key) && $value instanceof BlockPattern) {
                $value->type($key);
            }

            $this->pattern[$key] = Pattern::from($value);
        }

        $this->render  = $render;
    }

    public static function make(array $pattern, Closure|string|null $render = null)
    {
        return new static($pattern, $render);
    }

    public function pattern(mixed $key = null): ?Pattern
    {
        if (! is_null($key)) {
            return $this->pattern[$key] ?? null;
        }

        return Pattern::from($this->pattern);
    }

    public function render(GroupBlock $block): string
    {
        $render = $this->render;

        if ($render instanceof Closure) {
            return $render($block);
        }

        $data = $block->controller();

        if (is_string($render)) {
            return snippet($render, $data, true);
        }

        return snippet('blocks/groups/' . $block->type(), $data, true);
    }
}
