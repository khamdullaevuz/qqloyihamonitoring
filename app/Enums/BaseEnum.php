<?php

namespace App\Enums;

use App\Helpers\EnumBuilder;
use BadMethodCallException;

trait BaseEnum
{
    public static function __callStatic(string $method, mixed $arguments): EnumBuilder
    {
        if (!method_exists(new EnumBuilder(static::cases()), $method)) {
            throw new BadMethodCallException("Method {$method} does not exist.");
        }

        return (new EnumBuilder(static::cases()))
            ->{$method}(...$arguments);
    }

    /**
     * Exclude the given values from the enum cases.
     *
     * @param string|static ...$values The values to exclude.
     *
     * @return EnumBuilder The EnumBuilder instance with the remaining cases.
     */
    public static function except(mixed ...$values): EnumBuilder
    {
        return (new EnumBuilder(static::cases()))->except(...$values);
    }

    public static function only(mixed ...$values): EnumBuilder
    {
        return (new EnumBuilder(static::cases()))->only(...$values);
    }

    public static function toArray(): array
    {
        $arr = [];
        foreach (static::cases() as $case) {
            $arr[] = $case->value;
        }

        return $arr;
    }

    public static function toString(): string
    {
        return implode(',', self::toArray());
    }

    /**
     * Returns the enum cases in alphabetical order for easy copy-pasting.
     *
     * @return string
     */
    public static function resortEnum(): string
    {
        // Get all cases
        $cases = static::cases();

        // Sort cases alphabetically by value
        usort($cases, fn($a, $b) => strcmp($a->value, $b->value));

        // Generate the string output in `case ENUM = 'value';` format
        $output = '';
        foreach ($cases as $case) {
            $output .= "case {$case->name} = '{$case->value}';";
        }

        return $output;
    }
}
