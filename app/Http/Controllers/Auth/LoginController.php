<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserLoginRequest;
use App\Services\Account\UserService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    public function __construct(private UserService $userService) { }


    /**
     *
     * @OA\Post(
     *     tags={"Authentication"},
     *     description="User login via email and password",
     *     path="/api/login",
     *     requestBody={"$ref": "#/components/requestBodies/UserLoginRequest"},
     *     @OA\Response(response="200", description="Authentication completed successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/AuthenticateDTO"
     *             )
     *         )
     *      )
     * )
     * @param UserLoginRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(UserLoginRequest $request): JsonResponse
    {
       return response()->json(
           $this->userService->authenticateUser(
               username: $request->input('username'),
               password: $request->input('password')
           )
       );
    }
}
