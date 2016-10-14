<?php

namespace Xenex\Http\Controllers\User\Account;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Xenex\Http\Requests;
use Xenex\Http\Controllers\Controller;

class SettingController extends Controller
{
    protected $view = 'user.account.setting';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getSetting(): View
    {
        return view($this->view ?? 'user.account.setting');
    }

    public function postSetting(Request $request): RedirectResponse
    {

    }
}
