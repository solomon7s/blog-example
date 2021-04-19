<?php
declare(strict_types=1);

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BlogPostRequest
 * @package App\Http\Requests
 *
 * @OA\RequestBody(
 *     request="BlogPostRequest",
 *     description="Blog post information to add or update",
 *     @OA\MediaType(
 *          mediaType="application/json",
 *          @OA\Schema(
 *              @OA\Property( property="title", type="string"),
 *              @OA\Property( property="is_featured", type="boolean"),
 *              @OA\Property( property="content", type="string"),
 *         )
 *     )
 * )
 */
class BlogPostRequest extends FormRequest
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
            'title'   => [
                'required',
                'string',
                'min:3',
                'max:250',
            ],
            'content' => [
                'required',
                'string',
                'min:10',
                'max:10000'
            ],
            'is_featured' => [
                'boolean'
            ],
        ];
    }
}
