<?php

if ( ! function_exists('is_enum')) {
    /**
     * Check if a value is an enum.
     *
     * @param mixed $value
     *
     * @return bool
     */
    function is_enum(mixed $value): bool
    {
        return $value instanceof \UnitEnum;
    }
}
