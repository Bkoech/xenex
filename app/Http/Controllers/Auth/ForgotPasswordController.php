<?php

namespace Xenex\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Xenex\Components\Auth\ForgotPassword\InvalidUserException;
use Xenex\Components\Auth\ForgotPassword\UnknownResponseException;
use Xenex\Http\Controllers\Controller;
use Xenex\Components\Auth\ForgotPassword\Service as ForgotPasswordService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    protected $view = 'auth.passwords.email';
    protected $validatorRules = [
        'email' => 'required|email|exists:users|max:255',
    ];

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getReset(): View
    {
        return view($this->view ?? 'auth.passwords.email');
    }

    public function postEmail(Request $request): RedirectResponse
    {
        $service = new ForgotPasswordService();

        $validator = $service->validator($request->only(array_keys($this->validatorRules)), $this->validatorRules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $response = $service->action($request->only(array_keys($this->validatorRules)));
            return redirect()->back()->with('status', trans($response));
        } catch (InvalidUserException $e) {
            return redirect()->back()->withErrors(trans($e->getMessage()));
        } catch (UnknownResponseException $e) {
            return redirect()->back()->withErrors(trans($e->getMessage()));
        }
    }
}
