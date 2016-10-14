<?php

namespace Xenex\Http\Controllers\auth;

use Auth;
use Illuminate\Http\RedirectResponse;
use Xenex\Http\Controllers\Controller;

class LogoutController extends Controller
{
    protected $redirect = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postLogout(): RedirectResponse
    {
        Auth::logout();

        return redirect($this->redirect ?? '/');
    }
}
