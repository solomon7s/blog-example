<?php
declare(strict_types=1);

namespace App\Models\Blog;

use App\Models\Concerns\HasOwner;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory, UsesUuid, HasOwner;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'post_id'
    ];


    protected static function boot()
    {
        parent::boot();
        self::bootUsesUuid();
        self::bootHasOwner();
    }


    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
