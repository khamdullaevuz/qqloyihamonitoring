<?php

namespace App\Services\Auth;

use App\DTO\UserTokenDto;
use App\Exceptions\AuthException;
use App\Models\UserToken;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Encryption\DecryptException;
use JWTAuth;

class AuthService
{
    /**
     * @throws AuthException
     */
    public function login(array $data)
    {
        $credentials = [
            'phone'    => $data['phone'],
            'password' => $data['password'],
        ];

        if (!$token = auth()->attempt($credentials)) {
            throw new AuthException('Unauthorized', 400);
        }

        return $this->processToken($token);
    }

    /**
     * @throws AuthException
     */
    public function refresh(string $refresh_token)
    {
        try {
            $userToken = UserToken::firstWhere('refresh_token', $refresh_token);

            if ($userToken === null || $userToken->refresh_expired_at->lessThan(now())) {
                $userToken?->delete();

                throw new AuthException(__('validation.refresh_token_is_not_valid'), 401);
            }
            $token = auth()->login($userToken->user);

            return $this->processToken(token: $token, userToken: $userToken);
        } catch (DecryptException $decryptException) {
            throw new AuthException(__('validation.refresh_token_is_not_valid'), 400);
        }
    }

    public function logout()
    {
        $jwtToken = JWTAuth::getToken();
        if (!$jwtToken) {
            throw new AuthException(__('auth.token_not_provided'), 400);
        }

        $userToken = UserToken::firstWhere('token', $jwtToken->get());
        if ($userToken !== null) {
            $userToken->delete();
        }
    }

    public function processToken(string $token, ?UserToken $userToken = null): array
    {
        $refresh_token = refreshTokenGenerate();

        $dto = new UserTokenDto(
            user_id:            auth()->id(),
            token:              $token,
            refresh_token:      $refresh_token,
            expired_at:         CarbonImmutable::now()->addMinutes(config('jwt.ttl')),
            refresh_expired_at: CarbonImmutable::now()->addMinutes(config('jwt.refresh_ttl')),
        );

        UserToken::updateOrCreate(
            [
                'user_id' => auth()->id() ?? $userToken->user_id
            ],
            $dto->toArray()
        );

        return [
            'access_token'  => $token,
            'refresh_token' => $refresh_token,
            'expires_in'    => config('jwt.ttl') * 60,
            'refresh_ttl'   => config('jwt.refresh_ttl') * 60,
        ];
    }
}
