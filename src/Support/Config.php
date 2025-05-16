<?php

namespace Teardrops\Teardrops\Support;

class Config
{
    /**
     * Get the value of a configuration key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }
}
