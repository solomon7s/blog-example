<?php
declare(strict_types=1);

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CommentRequest
 * @package App\Http\Requests
 *
 * @OA\RequestBody(
 *     request="CommentRequest",
 *     description="Comment body to add or update",
 *     @OA\MediaType(
 *          mediaType="application/json",
 *          @OA\Schema(
 *              @OA\Property( property="body", type="string")
 *         )
 *     )
 * )
 */
class CommentRequest extends FormRequest
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
            'body' => [
                'required',
                'string',
                'min:2',
                'max:250',
            ]
        ];
    }
}
