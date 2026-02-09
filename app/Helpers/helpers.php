<?php

use App\Models\UserToken;
use Ramsey\Uuid\Uuid;

if(!function_exists('uuid'))
{
    function uuid(): string
    {
        return Uuid::uuid7()->toString();
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 4, $bigLetters = true, $smallLetters = true, $number = true): string
    {
        $characters = ($number ? '0123456789' : "") .
            ($smallLetters ? 'abcdefghijklmnopqrstuvwxyz' : "") .
            ($bigLetters ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : "");

        return substr(str_shuffle($characters), 0, $length);
    }
}

if (!function_exists('refreshTokenGenerate')) {
    function refreshTokenGenerate(): string
    {
        $token  = generateRandomString(50);
        $exists = UserToken::query()
            ->where('refresh_token', $token)
            ->exists();
        !$exists ? : refreshTokenGenerate();

        return $token;
    }
}

if(!function_exists('makeCookie'))
{
    function makeCookie(string $key, string $value, int $ttl)
    {
        return cookie(
            name: $key,
            value: $value,
            minutes: $ttl,
            path: '/',
            domain: str_replace(['http://', 'https://'], '', config('app.url')),
            secure: true,
            httpOnly: true,
            sameSite: 'None'
        );
    }
}

if(!function_exists('removeCookie'))
{
    function removeCookie(string $key)
    {
        return cookie(
            name: $key,
            value: '',
            minutes: -1,
            path: '/',
            domain: str_replace(['http://', 'https://'], '', config('app.url')),
            secure: true,
            httpOnly: true,
            sameSite: 'None'
        );
    }
}
