<?php

namespace IpnuIppnu\Package\Sso\Http;

interface HttpRequestInterface
{
    public function getCacheName() : string;
    public function uri() : string;
}
