<?php

namespace Corviz\Crow\Traits;

trait SelfCreate
{
    /**
     * @see static::__construct();
     *
     * @return static
     */
    public static function create(...$arguments)
    {
        return new static(...$arguments);
    }
}
