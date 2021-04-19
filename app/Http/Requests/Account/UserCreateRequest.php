<?php
declare(strict_types=1);

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserCreateRequest
 * @package App\Http\Requests
 *
 * @OA\RequestBody(
 *     request="UserCreateRequest",
 *     description="User object that needs to be registered into the system",
 *     @OA\MediaType(
 *          mediaType="application/json",
 *          @OA\Schema(
 *              @OA\Property( property="name", type="string"),
 *              @OA\Property( property="password", type="string"),
 *              @OA\Property( property="email", type="string", format="email")
 *         )
 *     )
 * )
 */
class UserCreateRequest extends FormRequest
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
            'name'      => [
                'required',
                'string',
                'max:250',
            ],
            'email'     => [
                'required',
                'email',
                'max:250',
                'unique:users,email',
            ],
            'password'  => [
                'required',
                'string',
                'min:6',
                'max:250'
            ]
        ];
    }
}
