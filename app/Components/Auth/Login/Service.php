<?php

namespace Xenex\Components\Auth\Login;

use Auth;
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

    public function action(array $credentials, bool $remember)
    {
        if(!Auth::attempt($credentials, $remember)) {
            throw new LoginFailedException();
        }
    }
}