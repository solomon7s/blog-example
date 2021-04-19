<?php
declare(strict_types=1);


namespace App\DataTransferObjects\Blog;


use App\DataTransferObjects\Account\UserDTO;
use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class CommentDTO
 * @package App\DataTransferObjects\Account
 * @OA\Schema()
 */
final class CommentDTO extends DataTransferObject
{
    /**
     * @var string
     * @OA\Property(type="string", property="id")
     */
    public string $id;

    /**
     * @var string
     * @OA\Property(type="string", property="body")
     */
    public string $body;

    /**
     * @var string
     * @OA\Property(type="string", property="created_at")
     */
    public string $created_at;

    /**
     * @var UserDTO
     * @OA\Property(type="object", property="user", ref="#/components/schemas/UserDTO")
     */
    public UserDTO $user;


    /**
     * @param Model $model
     * @return CommentDTO
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function createFromModel(Model $model): CommentDTO
    {
        $attrs = $model->getAttributes();
        $attrs['user'] = UserDTO::createFromModel($model->createdBy);

        return new self( $attrs );
    }
}
