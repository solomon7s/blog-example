<?php
declare(strict_types=1);

namespace App\DataTransferObjects\Account;


use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class UserDTO
 * @package App\DataTransferObjects\Account
 * @OA\Schema()
 */
final class UserDTO extends DataTransferObject
{
    /**
     * @var string
     * @OA\Property(type="string", property="id")
     */
    public string $id;

    /**
     * @var string
     * @OA\Property(type="string", property="name")
     */
    public string $name;

    /**
     * @var string
     * @OA\Property(type="string", property="email", format="email")
     */
    public string $email;


    public static function createFromModel(Model $model): UserDTO
    {
        return new self(
            $model->getAttributes()
        );
    }
}
