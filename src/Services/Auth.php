<?php

namespace IpnuIppnu\Package\Sso\Services;

use IpnuIppnu\Package\Sso\Http\HttpRequest;
use IpnuIppnu\Package\Sso\Http\HttpRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Auth implements HttpRequestInterface
{
    use HttpRequest;

    private $identifier;
    protected $encrypt = TRUE;
    protected $api = false;

    public function __construct()
    {
        $this->identifier = Cookie::get( sha1('SSO_SESSION') );
    }

    public function setFromApi($token){
        $this->api = $token;
        return $this;
    }

    public function uri(): string
    {
        return 'auth';
    }

    public function getCacheName(): string
    {
        return sha1('auth_' . ($this->api ? $this->api : $this->identifier));
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
