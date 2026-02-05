<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthController extends Controller implements HasMiddleware
{
    public function __construct(public AuthService $service) { }

    /**
     * Get a JWT via given credentials.
     *
     * @return array
     * @throws Exception
     */
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'phone'    => 'required|string',
                'password' => 'required|string',
            ]
        );

        return $this->service->login($credentials);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function logout()
    {
        $this->service->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return array|JsonResponse
     * @throws Exception
     */
    public function refresh(Request $request)
    {
        $refresh_token = $request->bearerToken();
        if ($refresh_token === null || $refresh_token === '') {
            return response()->json(
                [
                    'message' => __('validation.refresh_token_is_empty'),
                ],
                400);
        }

        return $this->service->refresh($refresh_token);
    }

    public static function middleware()
    {
        return [
            new Middleware('auth:api', except: ['login', 'refresh']),
        ];
    }
}
