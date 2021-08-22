<?php

if (!function_exists('env')) {

    /**
     * Get the environment variable if set, else return default value.
     *
     * @param string      $envVariable
     * @param string|null $default
     *
     * @return string
     */
    function env(string $envVariable, ?string $default = null): string
    {
        return isset($_ENV[$envVariable])
            ? strval($_ENV[$envVariable])
            : strval($default);
    }
}