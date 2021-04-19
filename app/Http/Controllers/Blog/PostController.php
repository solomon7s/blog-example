<?php
declare(strict_types=1);

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogPostRequest;
use App\Services\Blog\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{

    public function __construct(private PostService $postService) { }


    /**
     *
     * @OA\Get(
     *     tags={"Blog"},
     *     description="User login via email and password",
     *     path="/api/posts",
     *     @OA\Parameter(
     *         name="page",
     *         description="page number",
     *         in="query",
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="is_featured",
     *         description="is featured post {1, 0}",
     *         in="query",
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="author",
     *         description="post author id",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         description="sort posts, valid options {title, created_at, is_featured}",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="dir",
     *         description="Direction of post sort ASC or DESC",
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Posts retrieved successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/PostPaginationDTO"
     *             )
     *         )
     *      )
     * )
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(): JsonResponse
    {
       return response()->json(
           $this->postService->getPostsList()
       );
    }

    /**
     *
     * @OA\Post(
     *     tags={"Blog"},
     *     description="Create new blog post",
     *     path="/api/posts",
     *     security={{ "apiAuth": {} }},
     *     requestBody={"$ref": "#/components/requestBodies/BlogPostRequest"},
     *     @OA\Response(response="201", description="Post created successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/PostDTO"
     *             )
     *         )
     *      )
     * )
     * @param BlogPostRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(BlogPostRequest $request): JsonResponse
    {
        return response()->json(
            $this->postService->addPost(
                $request->validated()
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     *
     * @OA\Put(
     *     tags={"Blog"},
     *     description="Update user blog post",
     *     path="/api/posts/{id}",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         description="Post id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/BlogPostRequest"},
     *     @OA\Response(response="200", description="Blog post updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/PostDTO"
     *             )
     *         )
     *      )
     * )
     * @param string          $id
     * @param BlogPostRequest $request
     * @return JsonResponse
     */
    public function update(string $id, BlogPostRequest $request): JsonResponse
    {
        return response()->json(
            $this->postService->updatePost( $id, $request->validated() )
        );
    }


    /**
     *
     * @OA\Delete(
     *     tags={"Blog"},
     *     description="Delete user post",
     *     path="/api/posts/{id}",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         description="Post id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Blog post deleted successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/UpdateResponseDTO"
     *             )
     *         )
     *      )
     * )
     * @param string          $id
     * @param BlogPostRequest $request
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        $deleteStatus = $this->postService->deletePost($id);
        return response()->json(
            $deleteStatus,
            $deleteStatus->success ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }

}
