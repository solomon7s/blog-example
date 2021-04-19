<?php
declare(strict_types=1);

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogPostRequest;
use App\Http\Requests\Blog\CommentRequest;
use App\Services\Blog\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CommentController extends Controller
{

    public function __construct(
        private CommentService $commentService
    ) { }


    /**
     *
     * @OA\Get(
     *     tags={"Blog"},
     *     description="get comments list for blog post by id ordered by latest",
     *     path="/api/posts/{id}/comments",
     *     @OA\Parameter(
     *         name="id",
     *         description="Post id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         description="page number",
     *         in="query",
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Response(response="200", description="comments retrieved successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/CommentPaginationDTO"
     *             )
     *         )
     *      )
     * )
     * @param string $id target post id
     * @return JsonResponse
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function index(string $id): JsonResponse
    {
       return response()->json(
           $this->commentService->getPostComments($id)
       );
    }

    /**
     *
     * @OA\Post(
     *     tags={"Blog"},
     *     description="Create new comment about blog post",
     *     path="/api/posts/{id}/comment",
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
     *     requestBody={"$ref": "#/components/requestBodies/CommentRequest"},
     *     @OA\Response(response="201", description="Comment created successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/CommentDTO"
     *             )
     *         )
     *      )
     * )
     * @param string $id
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function create(string $id, CommentRequest $request): JsonResponse
    {
        return response()->json(
            $this->commentService->addComment(
                $id,
                $request->validated()
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     *
     * @OA\Put(
     *     tags={"Blog"},
     *     description="Update user comment",
     *     path="/api/posts/{id}/comment/{cid}",
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
     *     @OA\Parameter(
     *         name="cid",
     *         description="Comment id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/CommentRequest"},
     *     @OA\Response(response="200", description="Comment updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/CommentDTO"
     *             )
     *         )
     *      )
     * )
     * @param string          $id
     * @param string          $cid
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function update(string $id, string $cid, CommentRequest $request): JsonResponse
    {
        return response()->json(
            $this->commentService->updateComment(
                $cid,
                $request->validated()
            )
        );
    }


    /**
     *
     * @OA\Delete(
     *     tags={"Blog"},
     *     description="Delete user comment",
     *     path="/api/posts/{id}/comment/{cid}",
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
     *     @OA\Parameter(
     *         name="cid",
     *         description="Comment id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Comment deleted successfully",
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
     * @param string          $cid
     * @return JsonResponse
     */
    public function delete(string $id, string $cid): JsonResponse
    {
        $deleteStatus = $this->commentService->deleteComment($cid);
        return response()->json(
            $deleteStatus,
            $deleteStatus->success ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }

}
