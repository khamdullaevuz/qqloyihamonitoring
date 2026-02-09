<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthController extends Controller implements HasMiddleware
{
    public function __construct(public AuthService $service) { }

    /**
     * Get a JWT via given credentials.
     *
     * @return Response
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

        $result = $this->service->login($credentials);

        $expires_in = $result['expires_in'] / 60;
        $refresh_ttl = $result['refresh_ttl'] / 60;

        $accessToken = $result['access_token'];
        $refreshToken = $result['refresh_token'];

        $accessToken = makeCookie('QQ_USER_AT', $accessToken, $expires_in);
        $accessTokenTtl = makeCookie('QQ_USER_ATT', $expires_in, $expires_in);
        $refreshToken = makeCookie('QQ_USER_RT', $refreshToken, $refresh_ttl);
        $refreshTokenTtl = makeCookie('QQ_USER_RTT', $refresh_ttl, $refresh_ttl);

        return response()
            ->noContent()
            ->withCookie($accessToken)
            ->withCookie($accessTokenTtl)
            ->withCookie($refreshToken)
            ->withCookie($refreshTokenTtl);
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
     * @return Response
     * @throws Exception
     */
    public function logout()
    {
        $this->service->logout();

        $accessToken     = removeCookie('D_USER_AT');
        $accessTokenTtl  = removeCookie('D_USER_ATT');
        $refreshToken    = removeCookie('D_USER_RT');
        $refreshTokenTtl = removeCookie('D_USER_RTT');

        return response()
            ->noContent()
            ->withCookie($accessToken)
            ->withCookie($accessTokenTtl)
            ->withCookie($refreshToken)
            ->withCookie($refreshTokenTtl);
    }

    /**
     * Refresh a token.
     *
     * @return Response|JsonResponse
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

        $result = $this->service->refresh($refresh_token);
        $expires_in = $result['expires_in'] / 60;
        $refresh_ttl = $result['refresh_ttl'] / 60;

        $accessToken = $result['access_token'];
        $refreshToken = $result['refresh_token'];

        $accessToken = makeCookie('QQ_USER_AT', $accessToken, $expires_in);
        $accessTokenTtl = makeCookie('QQ_USER_ATT', $expires_in, $expires_in);
        $refreshToken = makeCookie('QQ_USER_RT', $refreshToken, $refresh_ttl);
        $refreshTokenTtl = makeCookie('QQ_USER_RTT', $refresh_ttl, $refresh_ttl);

        return response()
            ->noContent()
            ->withCookie($accessToken)
            ->withCookie($accessTokenTtl)
            ->withCookie($refreshToken)
            ->withCookie($refreshTokenTtl);
    }

    public static function middleware()
    {
        return [
            new Middleware('auth:api', except: ['login', 'refresh']),
        ];
    }
}
