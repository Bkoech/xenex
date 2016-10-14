<?php

namespace Xenex\Components\Auth\ResetPassword;

use Auth;
use Password;
use Validator;

class Service
{
    public function __construct()
    {
    }

    public function validator(array $data, array $rules): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, $rules);
    }

    public function action(array $data)
    {
        $response = Password::broker()->reset($data, function ($user, $password) {
            $user->update([
                'password' => bcrypt($password),
            ]);
            Auth::login($user);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return $response;
            case Password::INVALID_PASSWORD:
                throw new InvalidPasswordException($response);
                break;
            case Password::INVALID_TOKEN:
                throw new InvalidTokenException($response);
                break;
            default:
                throw new UnknownResponseException($response);
                break;
        }
    }
}
