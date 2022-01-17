<?php

namespace IpnuIppnu\Package\Sso;

use IpnuIppnu\Package\Sso\Services\Auth;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permission)
    {
        if( $request->header('Authorization', false) && preg_match("/^Bearer /", $request->header('Authorization', "")) )
        {
            $final = $this->modify($request, $request->header('Authorization'));
            if( $final ) return $next($final);
        }

        throw new AuthenticationException();
    }

    private function modify(Request $request, String $token)
    {
        if( $result = app(Auth::class)->setFromApi($token)->execute() )
        {
            $request->credential = $result;
            return $request;
        }

        return false;
    }
}
