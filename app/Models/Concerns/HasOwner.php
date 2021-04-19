<?php
declare(strict_types=1);

namespace App\Models\Concerns;


use App\Models\Account\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOwner
{

    protected static function bootHasOwner(): void
    {
        static::creating(function ($model) {
            $userId = auth()->id();
            if ($userId) {
                $model->created_by = $userId;
            }
        });

        static::updating(function ($model) {
            $userId = auth()->id();
            if ($userId) {
                $model->updated_by = $userId;
            }
        });

    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
