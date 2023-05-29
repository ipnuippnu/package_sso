<?php

namespace IpnuIppnu\Package\Sso;

use IpnuIppnu\Package\Sso\Services\Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class Middleware
{
    private $reauth_endpoint = "/reauth";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permission)
    {
        if( Cookie::has( sha1('SSO_SESSION') ) )
            if( $final = $this->modify($request) )
                return $next($final);

        return redirect( $this->reauthUrl() );
    }

    private function modify(Request $request)
    {
        // Tidak perlu catch, karena
        // jika tidak cocok langsung
        // di redirect ke sso
        if( $result = app(Auth::class)->execute() )
        {
            $request->credential = $result;
            return $request;
        }

        return false;
    }

    private function reauthUrl()
    {
        return  config('sso.url') .
                $this->reauth_endpoint . '/' .
                base64_encode(URL::current());
    }
}
