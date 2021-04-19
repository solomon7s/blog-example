<?php


namespace App\Repositories;


use App\Models\Account\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?Model
    {
        return $this->createQueryBuilder()
            ->where('email', $email)
            ->first();
    }

}
