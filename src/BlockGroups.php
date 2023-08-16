<?php

namespace LukasKleinschmidt\BlockGroups;

use Kirby\Cms\Blocks;
use Stringable;

class BlockGroups implements Stringable
{
    protected static $groups = [];

    protected Preg $preg;

    public function __construct(
        protected Blocks $blocks,
    ) {}

    public static function make(Blocks $blocks): static
    {
        return new static($blocks);
    }

    public static function groups(): array
    {
        return static::$groups;
    }

    public static function define(array|string $type, Group|array $group = null): void
    {
        if (is_array($type)) {
            foreach ($type as $key => $value) {
                static::define($key, $value);
            }

            return;
        }

        if (is_array($group)) {
            $group = new Group($group);
        }

        static::$groups[$type] = $group;
    }

    public function preg(): Preg
    {
        return $this->preg ??= new Preg($this->blocks);
    }

    public function match(Group|Pattern|array|string $pattern, bool $exact = false, &$matches = []): bool
    {
        return $this->preg()->match($pattern, $exact, $matches);
    }

    public function matchAll(mixed $pattern, bool $exact = false, &$matches = []): bool
    {
        return $this->preg()->matchAll($pattern, $exact, $matches);
    }

    protected function insertGroup(string $type, Group $group, array $matches): static
    {
        $blocks = &$this->blocks;

        // PHPs preg_match always includes the full match as the first element.
        // Since the full match is not needed we can remove it from the matches.

        array_shift($matches);

        $data  = [];
        $prev  = null;
        $index = null;

        foreach ($matches as $key => $match) {

            // PHPs preg_match includes both the named and numeric results for a match.
            // But since named matches always come first, we can ignore the second one.
            // This logic also works if there we don't have any named matches at all.

            if ($prev === $match) {
                continue;
            };

            $prev = $match;
            $once = false;

            // if (empty($match[0][0])) {
            //     continue;
            // }

            $pattern = $group->pattern($key);

            if ($pattern instanceof Contracts\Matches) {
                $once = $pattern->matchesOnce();
            }

            preg_match_all('/.*:(.{36}).*/', $match[0][0], $keys);

            $index ??= $blocks->indexOf($keys[1][0]);
            $values  = $blocks->find($keys[1]);
            $blocks  = $blocks->not($keys[1]);

            $data[$key] = $once
                ? $values->first()
                : $values;
        }

        $block = new GroupBlock([
            'type'  => $type,
            'group' => $group,
            'data'  => $data,
        ]);

        $data = $blocks->data();

        // The blocks data array uses string keys. To insert the group block at
        // the correct index we slice the array at the intended index and merge
        // it back together.

        $a = array_slice($data, 0, $index, true);
        $b = array_slice($data, $index, null, true);

        $blocks->data($a + [$block->id() => $block] + $b);

        return $this;
    }

    public function insert(array $groups): static
    {
        foreach ($groups as $type) {
            // TODO: Validate groups input
            $group = static::$groups[$type];

            if ($this->matchAll($group->pattern(), false, $matches)) {
                $this->insertGroup($type, $group, $matches);
            }
        }

        return $this;
    }

    public function blocks(): Blocks
    {
        return $this->blocks;
    }

    public function __toString(): string
    {
        return $this->blocks->toHtml();
    }
}
