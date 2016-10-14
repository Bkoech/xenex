<?php

namespace Xenex\Http\Controllers\Auth;

use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Xenex\Components\Auth\ResetPassword\InvalidPasswordException;
use Xenex\Components\Auth\ResetPassword\InvalidTokenException;
use Xenex\Components\Auth\ResetPassword\Service as ResetPasswordService;
use Xenex\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    protected $view = 'auth.passwords.reset';
    protected $redirect = '/home';
    protected $validatorRules = [
        'token' => 'required',
        'email' => 'required|email|max:255',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6',
    ];

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getReset(string $token): View
    {
        return view($this->view ?? 'auth.passwords.reset')
                ->with('token', $token);
    }

    public function postReset(Request $request)
    {
        $service = new ResetPasswordService();

        $validator = $service->validator($request->all(), $this->validatorRules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $response = $service->action($request->only(array_keys($this->validatorRules)));

            return redirect($this->redirect ?? '/home')->with('status', trans($response));
        } catch (InvalidPasswordException $e) {
            return redirect()->back()->withErrors(['email' => trans($e->getMessage())]);
        } catch (InvalidTokenException $e) {
            return redirect()->back()->withErrors(['email' => trans($e->getMessage())]);
        }
    }
}
