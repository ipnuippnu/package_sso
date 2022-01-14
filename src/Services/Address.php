<?php

namespace IpnuIppnu\Package\Sso\Services;

use IpnuIppnu\Package\Sso\Http\HttpRequest;
use IpnuIppnu\Package\Sso\Http\HttpRequestInterface;

class Address implements HttpRequestInterface
{
    use HttpRequest;

    public $method = 'POST';

    private $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function getCacheName(): string
    {
        return sha1('address_' . $this->id);
    }

    public function uri(): string
    {
        return 'address';
    }

    public function data(): array
    {
        return [
            'code' => $this->id
        ];
    }

}
