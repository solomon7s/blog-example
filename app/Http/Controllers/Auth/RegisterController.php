<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserCreateRequest;
use App\Services\Account\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisterController extends Controller
{

    public function __construct(private UserService $userService) { }


    /**
     *
     * @OA\Post(
     *     tags={"Authentication"},
     *     description="Register new user",
     *     path="/api/register",
     *     requestBody={"$ref": "#/components/requestBodies/UserCreateRequest"},
     *     @OA\Response(response="201", description="User registration completed successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/UserDTO"
     *             )
     *         )
     *      )
     * )
     * @param UserCreateRequest $request
     * @return JsonResponse
     */
    public function __invoke(UserCreateRequest $request): JsonResponse
    {
       return response()->json(
           $this->userService->registerUser($request->validated()),
           Response::HTTP_CREATED
       );
    }
}
