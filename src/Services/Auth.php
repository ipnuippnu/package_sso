<?php

namespace IpnuIppnu\Package\Sso\Services;

use IpnuIppnu\Package\Sso\Http\HttpRequest;
use IpnuIppnu\Package\Sso\Http\HttpRequestInterface;
use Illuminate\Http\Request;

class Auth implements HttpRequestInterface
{
    use HttpRequest;

    private $identifier;
    protected $encrypt = TRUE;
    protected $api;

    public function setFromApi($token){
        $this->api = $token;
        return $this;
    }

    public function setId(Request $request)
    {
        $this->identifier = $request->cookie( sha1('SSO_SESSION') );
        return $this;
    }

    public function uri(): string
    {
        return 'auth';
    }

    public function getCacheName(): string
    {
        return sha1('auth_' . $this->api ?? $this->identifier);
    }

    public function headers(): array
    {
        if( $this->api ) return [
            'Authorization' => $this->api
        ];

        return [
            'request-session' => $this->identifier
        ];
    }
}
