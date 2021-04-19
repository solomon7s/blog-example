<?php
declare(strict_types=1);

namespace App\Models\Blog;

use App\Models\Concerns\HasOwner;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, UsesUuid, HasOwner;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'is_featured'
    ];

    protected $attributes = [
        'is_featured' => false
    ];

    protected static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
        self::bootHasOwner();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

}
