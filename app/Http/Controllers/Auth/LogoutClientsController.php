<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutClientsController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->middleware('guest:client')->except('logout');
    }

    public function LogoutClient()
    {

        dd('logger');
        \Session::flush();
        \Auth::logout();

        return redirect()->route('client.login');
    }
}