<?php

namespace App\Http\Controllers;

use App\Domains\Auth\AuthService;
use App\Domains\Auth\Dto\LoginDto;
use App\Domains\Auth\Dto\UpdateDto;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Requests\LoginRequest;
use App\Domains\Auth\Requests\UpdateRequest;
use App\Domains\Auth\Resources\TokenResource;
use App\Domains\Auth\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {

    }

    #[OA\Put(path: '/login', description: 'Update user')]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: "#/components/schemas/LoginRequest",
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Update user information',
        content: new OA\JsonContent(
            ref: "#/components/schemas/TokenResponse",
        )
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $loginDto = new LoginDto($request);

        $user = $this->authService->login($loginDto);

        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return new TokenResource($user)->toResponse($request);
    }

    #[OA\Put(path: '/user/update', description: 'Update user')]
    #[OA\Parameter(name: 'Authorization', in: 'header', required: true, schema: new OA\Schema(
        type: "string"
    ), example: 1234)]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: "#/components/schemas/UpdateUserRequest",
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Update user information',
        content: new OA\JsonContent(
            ref: "#/components/schemas/UpdateUserResponse",
        )
    )]
    public function update(UpdateRequest $request): JsonResponse
    {
        $updateDto = new UpdateDto($request);

        $updatedUser = $this->authService->update($updateDto);

        return new UserResource($updatedUser)->toResponse($request);
    }

    //TODO REFACTORING
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    //TODO REFACTORING
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'age' => 'required|int|min:0',
        ]);


        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'age' => $validated['age'],
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

}
