<?php

namespace LukasKleinschmidt\BlockGroups;

class Block
{
    // public static function after(string|array $value)
    // {
    //     return new AfterPattern($value);
    // }

    // public static function before(string|array $value)
    // {
    //     return new BeforePattern($value);
    // }

    // public static function data(string|array $value)
    // {
    //     return new DataPattern($value);
    // }

    public static function pattern(string|array $value): BlockPattern
    {
        return new BlockPattern($value);
    }
}
