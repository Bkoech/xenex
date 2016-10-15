<?php

namespace Xenex\Http\Controllers\User\Account;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Xenex\Components\User\Account\Password\CurrentPasswordNotMatchException;
use Xenex\Http\Controllers\Controller;
use Xenex\Components\User\Account\Password\Service as PasswordService;

class PasswordController extends Controller
{
    protected $view = 'user.account.password';
    protected $redirect = '/user/account/password';
    protected $validatorRules = [
        'current_password' => 'required|min:6',
        'password' => 'required|min:6|confirmed',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPassword(): View
    {
        return view($this->view ?? '/user.account.password');
    }

    public function postPassword(Request $request): RedirectResponse
    {
        $service = new PasswordService();

        $validator = $service->validator($request->all(), $this->validatorRules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $service->action($request->only(array_keys($this->validatorRules)));
            flash('密碼已修改成功，下次登入時請使用新密碼', 'success');

            return redirect($this->redirect ?? '/user/account/password');
        } catch (CurrentPasswordNotMatchException $e) {
            flash('現在密碼錯誤，無法修改密碼', 'danger');

            return redirect()->back();
        }
    }
}
