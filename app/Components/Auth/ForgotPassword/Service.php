<?php

namespace Xenex\Components\Auth\ForgotPassword;

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

    public function action(array $data): string
    {
        $response = Password::broker()->sendResetLink($data);

        if ($response === Password::INVALID_USER) {
            throw new InvalidUserException($response);
        }

        else if ($response === Password::RESET_LINK_SENT) {
            return $response;
        }

        throw new UnknownResponseException($response);
    }
}