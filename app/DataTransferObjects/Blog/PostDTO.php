<?php
declare(strict_types=1);

namespace App\DataTransferObjects\Blog;


use App\DataTransferObjects\Account\UserDTO;
use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class PostDTO
 * @package App\DataTransferObjects\Account
 * @OA\Schema()
 */
final class PostDTO extends DataTransferObject
{
    /**
     * @var string
     * @OA\Property(type="string", property="id")
     */
    public string $id;

    /**
     * @var string
     * @OA\Property(type="string", property="title")
     */
    public string $title;

    /**
     * @var string
     * @OA\Property(type="string", property="content")
     */
    public string $content;

    /**
     * @var string
     * @OA\Property(type="string", property="created_at")
     */
    public string $created_at;

    /**
     * @var bool
     * @OA\Property(type="boolean", property="is_featured")
     */
    public bool $is_featured;

    /**
     * @var int
     * @OA\Property(type="int", property="comments_count")
     */
    public int $comments_count = 0;

    /**
     * @var UserDTO
     * @OA\Property(type="object", property="user", ref="#/components/schemas/UserDTO")
     */
    public UserDTO $user;


    /**
     * @param Model $model
     * @return PostDTO
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function createFromModel(Model $model): PostDTO
    {
        $postAttr = $model->getAttributes();
        $postAttr['user'] = UserDTO::createFromModel($model->createdBy);

        return new self( $postAttr );
    }
}
