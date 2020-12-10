<?php

namespace Dwaincore\Authmgt;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dwaincore\Authmgt\Authmgt
 */
class AuthmgtFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'authmgt';
    }
}
