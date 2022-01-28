<?php

namespace Support\Classes;

class Action
{
    public static function make()
    {
        return app(static::class);
    }

    public static function run(...$params)
    {
        return static::make()->handle(...$params);
    }
}