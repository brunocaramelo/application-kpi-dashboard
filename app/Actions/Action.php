<?php

namespace App\Actions;

class Action
{

    public static function run(...$arguments)
    {
        try {
            return app(static::class)->handle(...$arguments);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}