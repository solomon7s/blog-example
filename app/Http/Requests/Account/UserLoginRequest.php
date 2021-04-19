<?php
declare(strict_types=1);

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserCreateRequest
 * @package App\Http\Requests
 *
 * @OA\RequestBody(
 *     request="UserLoginRequest",
 *     description="User object that needs to be registered into the system",
 *     @OA\MediaType(
 *          mediaType="application/json",
 *          @OA\Schema(
 *              @OA\Property( property="username", type="string", format="email"),
 *              @OA\Property( property="password", type="string")
 *         )
 *     )
 * )
 */
class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'    => [
                'required',
                'email',
                'max:250'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:250'
            ]
        ];
    }
}
