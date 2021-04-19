<?php
declare(strict_types=1);


namespace App\Services\Account;


use App\DataTransferObjects\Account\AuthenticateDTO;
use App\DataTransferObjects\Account\UserDTO;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{

    public function __construct(
        private UserRepository $userRepo
    ) { }

    /**
     * Register new user to database and return DTO
     *
     * @param array $userData
     * @return UserDTO
     */
    public function registerUser(array $userData): UserDTO
    {
        $userData['password'] = Hash::make($userData['password']);
        $user = $this->userRepo->create($userData);
        return UserDTO::createFromModel($user);
    }


    public function authenticateUser(string $username, string $password): AuthenticateDTO
    {
        $user = $this->userRepo->findByEmail($username);
        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }
        $accessToken = $user->createToken('test_device')->plainTextToken;

        return AuthenticateDTO::create(
            $accessToken,
            UserDTO::createFromModel($user)
        );
    }


}
