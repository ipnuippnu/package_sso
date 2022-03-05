<?php

namespace IpnuIppnu\Package\Sso\Http;

use Exception;
use IpnuIppnu\Package\Sso\Cache;
use Illuminate\Support\Facades\Http;

trait HttpRequest
{
    use Cache;

    public function execute()
    {
        if( $cache = $this->getCache() )
            return $cache;

        $client = Http::withOptions([
            'base_uri' => config('sso.url') . '/api/',
            'verify' => config('sso.verified'),
            'headers' => array_merge($this->headers(), [
                'accept'                => 'application/json',
                'request-version'       => config('sso.version')
            ])
        ]);

        $req = $client->{$this->method ?? 'GET'}($this->uri(), $this->data());

        if( $req->failed() )
        {
            if( in_array($req->getStatusCode(), [403, 422]) ) return null;
            throw new Exception("Kesalahan Sistem SSO: " . $req->getStatusCode());
        }

        $response = $req->body();

        if( $result = json_decode($response) )
        {
            $this->setCache($result);
            return $result;
        }

        throw new Exception("Respond dari server bukan json: " . $response);
    }

    public function data() : array
    {
        return [];
    }

    public function headers() : array
    {
        return [];
    }
}
