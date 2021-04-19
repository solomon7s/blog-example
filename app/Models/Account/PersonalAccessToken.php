<?php


namespace App\Models\Account;

use App\Models\Concerns\UsesUuid;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{

    use UsesUuid;


    protected static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
    }


}
