<?php

namespace IpnuIppnu\Package\Sso;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cache as CacheLaravel;
trait Cache {

    private static $ttl = 5;

    public function getCache()
    {
        if( !isset($this->encrypt) || $this->encrypt == FALSE )
            return CacheLaravel::get($this->getCacheName());

        if( $result = CacheLaravel::get($this->getCacheName()) )
            try {
                return Crypt::decrypt($result);
            } catch (DecryptException $e) {
                CacheLaravel::forget($this->getCacheName());
            }

        return null;
    }

    public function setCache($data) : bool
    {
        if( isset($this->encrypt) && $this->encrypt === TRUE )
            $data = Crypt::encrypt($data);

        if( CacheLaravel::put($this->getCacheName(), $data, $this->ttl ?? self::$ttl) )
            return true;

        return false;
    }

}
