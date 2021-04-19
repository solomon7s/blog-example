<?php
declare(strict_types=1);

namespace App\Models\Concerns;


use Illuminate\Support\Str;

trait UsesUuid
{


    /**
     * stop auto incrementing for primary key
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }


    /**
     * return primary key type of the eloquent model
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }


    protected static function bootUsesUuid(): void
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }


}
