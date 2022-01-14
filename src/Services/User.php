<?php

namespace IpnuIppnu\Package\Sso\Services;

use IpnuIppnu\Package\Sso\Http\HttpRequest;
use IpnuIppnu\Package\Sso\Http\HttpRequestInterface;

class User implements HttpRequestInterface
{
    use HttpRequest;

    public $method = 'POST';

    private $id;

    public function get($id)
    {
        $this->id = $id;
        return $this->execute();
    }

    public function getCacheName(): string
    {
        return sha1('user_' . $this->id);
    }

    public function uri(): string
    {
        return 'user';
    }

    public function data(): array
    {
        return [
            'id' => $this->id
        ];
    }

}
