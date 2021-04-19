<?php
declare(strict_types=1);

namespace App\Models\Account;

use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UsesUuid, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];


    protected static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
    }


    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'created_by');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'created_by');
    }


}
