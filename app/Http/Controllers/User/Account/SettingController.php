<?php

namespace Xenex\Http\Controllers\User\Account;

use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Xenex\Http\Requests;
use Xenex\Http\Controllers\Controller;
use Xenex\Components\User\Account\Setting\Service as SettingService;

class SettingController extends Controller
{
    protected $view = 'user.account.setting';
    protected $redirect = '/user/account/setting';
    protected $validatorRules = [
        'email' => 'required|email|max:255',
        'name' => 'required|max:255'
    ];

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
        $service = new SettingService();

        $this->validatorRules['email'] .= '|unique:users,email,'.Auth::user()->id;
        $validator = $service->validator($request->all(), $this->validatorRules);
        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        $changed = $service->action($request->only(array_keys($this->validatorRules)));

        if (count($changed) === 0) {
            flash('帳號資料未變更', 'info');
        }
        else {
            flash('帳號資料變更成功', 'success');
        }

        return redirect($this->redirect ?? '/user/account/setting');
    }
}
