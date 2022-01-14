<?php

namespace IpnuIppnu\Package\Sso;

use IpnuIppnu\Package\Sso\Services\Address;
use IpnuIppnu\Package\Sso\Services\Auth;
use IpnuIppnu\Package\Sso\Services\User;

class Service
{
    public function credential()
    {
        return app(Auth::class)->execute();
    }

    public function address($id = null)
    {
        return (new Address($id))->execute();
    }

    public function user($id)
    {
        return app(User::class)->get($id);
    }

    public function role($name)
    {
        return $this->credential()->role->name == $name;
    }
}
