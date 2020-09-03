<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public $isAdmin;

    public function __construct()
    {
        if (Auth::user()) {
            $this->isAdmin = Auth::user()->isAdministrator();
        } else {
            $this->isAdmin = false;
        }

        $this->middleware('setPass')->except([
            'setPasswordPage',
            'setPassword',
        ]);
    }
}
