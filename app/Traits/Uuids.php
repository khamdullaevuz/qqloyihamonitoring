<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

/**
 * Trait Uuids
 * @package Modules\Static\Entities\Traits
 * @psalm-api
 */
trait Uuids
{
    /**
     * @psalm-api
     */
    protected static function bootUuids(): void
    {
        static::creating(function (self $model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = uuid();
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
