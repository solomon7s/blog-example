<?php
declare(strict_types=1);


namespace App\DataTransferObjects\Account;


use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class AuthenticateDTO
 * @package App\DataTransferObjects\Account
 *
 * @OA\Schema()
 */
final class AuthenticateDTO extends DataTransferObject
{

    /**
     * @var string
     * @OA\Property(type="string", property="access_token")
     */
    public string $access_token;

    /**
     * @var UserDTO
     * @OA\Property(type="object", property="user", ref="#/components/schemas/UserDTO")
     */
    public UserDTO $user;


    public static function create(string $token, DataTransferObject $userDto): self
    {
        return new self(
            access_token: $token,
            user: $userDto
        );
    }
}
