<?php

namespace Xenex\Components\User\Account\Password;

use Auth;
use Hash;
use Validator;
use Xenex\User;

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
        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($data['current_password'], $user->password)) {
            $user->password = bcrypt($data['password']);
            return $user->save();
        }

        throw new CurrentPasswordNotMatchException();
    }
}