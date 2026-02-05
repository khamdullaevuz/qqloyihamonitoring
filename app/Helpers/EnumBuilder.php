<?php

namespace App\Helpers;

class EnumBuilder
{
    private array $cases;

    // Constructor initializes with the enum cases
    public function __construct(array $cases)
    {
        $this->cases = $cases;
    }

    /**
     * Exclude the given values from the enum cases.
     *
     * @param string|static ...$values The values to exclude.
     *
     * @return EnumBuilder The EnumBuilder instance with the remaining cases.
     */
    public function except(mixed ...$values): self
    {
        // Convert all values to their string representation
        $excludeValues = array_map(function ($value) {
            // If value is an instance of the enum class, use its value, otherwise use the string directly
            return is_object($value) ? $value->value : $value;
        }, $values);

        $this->cases = array_filter($this->cases, function ($case) use ($excludeValues) {
            return !in_array($case->value, $excludeValues);
        });

        return $this; // Return self for chaining
    }

    //only
    public function only(mixed ...$values): self
    {
        $includeValues = array_map(function ($value) {
            return is_object($value) ? $value->value : $value;
        }, $values);

        $this->cases = array_filter($this->cases, function ($case) use ($includeValues) {
            return in_array($case->value, $includeValues);
        });

        return $this;
    }


    public function sortBy(string $direction = 'asc'): self
    {
        usort($this->cases, function ($a, $b) use ($direction) {
            if ($direction === 'asc') {
                return $a->value <=> $b->value;
            }

            return $b->value <=> $a->value;
        });

        return $this;
    }

    public function map(callable $callback): self
    {
        $this->cases = array_map($callback, $this->cases);

        return $this;
    }

    // Method to return the remaining cases as an array
    public function toArray(): array
    {
        return array_map(fn($case) => $case->value, $this->cases);
    }

    // Method to return the remaining cases as a string
    public function toString(): string
    {
        return implode(',', $this->toArray());
    }

    public function implode(string $glue = ','): string
    {
        return implode($glue, $this->toArray());
    }
}

