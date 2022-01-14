<?php

namespace IpnuIppnu\Package\Sso;

use Illuminate\Support\Facades\Facade;

class Facades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'auth_sso';
    }
}
