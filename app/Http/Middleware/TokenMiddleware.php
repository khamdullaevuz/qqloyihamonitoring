<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if(!$token && ($request->hasCookie('QQ_USER_AT') || $request->hasCookie('D_USER_RT')))
        {
            if($request->hasCookie('QQ_USER_AT'))
            {
                $token = $request->cookie('QQ_USER_AT');
            }

            if(mb_stripos($request->path(), 'web/auth/refresh') !== false)
            {
                if($request->hasCookie('QQ_USER_RT'))
                {
                    $token = $request->cookie('QQ_USER_RT');
                }
            }

            if($token)
            {
                $request->headers->set('Authorization', 'Bearer ' . $token);
            }
        }

        return $next($request);
    }
}
