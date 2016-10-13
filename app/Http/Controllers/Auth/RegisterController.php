<?php

namespace Xenex\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Xenex\Components\Auth\Register\Service;
use Xenex\Http\Controllers\Controller;

class RegisterController extends Controller
{
    protected $view = 'auth.register';
    protected $redirect = '/home';
    protected $validatorRules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed',
    ];

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRegister(): View
    {
        return view($this->view ?? 'auth.register');
    }

    public function postRegister(Request $request): RedirectResponse
    {
        $service = new Service();
        $validator = $service->validator($request->all(), $this->validatorRules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        Auth::login($service->action($this->userdata($request)));

        return redirect($this->redirect ?? '/home');
    }

    protected function userdata(Request $request): array
    {
        $user = $request->only(array_keys($this->validatorRules));
        $user['password'] = bcrypt($user['password']);

        return $user;
    }
}
