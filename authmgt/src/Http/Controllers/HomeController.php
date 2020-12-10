<?php

namespace Dwaincore\Authmgt\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class HomeController
{
    public function __invoke(Request $request)
    {
        return "ok";
    }

}
