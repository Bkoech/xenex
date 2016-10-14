<?php

namespace Xenex\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Xenex\Components\Auth\Login\LoginFailedException;
use Xenex\Components\Auth\Login\Service as LoginService;
use Xenex\Components\Auth\Login\TooManyRequestsException;
use Xenex\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $view = 'auth.login';
    protected $redirect = '/home';
    protected $validatorRules = [
        'email' => 'required|email|max:255',
        'password' => 'required|min:6',
    ];

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getLogin(): View
    {
        return view($this->view ?? 'auth.login');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $service = new LoginService();

        $validator = $service->validator($request->all(), $this->validatorRules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $service->action($request->only(array_keys($this->validatorRules)), $request->has('remember'));

            return redirect($this->redirect ?? '/home');
        } catch (LoginFailedException $e) {
            return redirect('/login')->withErrors(['email' => trans('auth.failed')]);
        } catch (TooManyRequestsException $e) {
            return redirect('/login')->withErrors(['email' => trans('auth.throttle')]);
        }
    }
}
