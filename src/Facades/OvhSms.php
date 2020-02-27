<?php

namespace Okn\OvhSms\Facades;

use Illuminate\Support\Facades\Facade;

class OvhSms extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ovhsms';
    }
}
