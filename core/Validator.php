<?php
/**
 * Small reusable server-side validation helpers used by controllers.
 * Each method returns true when valid, or an error message string when invalid.
 */
class Validator
{
    public static function required($value, string $label)
    {
        return trim((string) $value) === '' ? "$label is required." : true;
    }

    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : 'Please enter a valid email address.';
    }

    public static function minLength($value, int $min, string $label)
    {
        return strlen((string) $value) >= $min ? true : "$label must be at least $min characters.";
    }

    public static function numberMin($value, float $min, string $label)
    {
        return is_numeric($value) && (float) $value >= $min ? true : "$label must be a number of at least $min.";
    }

    public static function inList($value, array $allowed, string $label)
    {
        return in_array($value, $allowed, true) ? true : "$label is invalid.";
    }
}
