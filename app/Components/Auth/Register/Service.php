<?php

namespace Xenex\Components\Auth\Register;

use Illuminate\Auth\Events\Registered;
use Validator;
use Xenex\User;

class Service
{
    public function __construct()
    {
    }

    /**
     * @param array $data
     * @param array $rules
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data, array $rules): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, $rules);
    }

    /**
     * @param array $data
     * @return User
     */
    public function action(array $data): User
    {
        event(new Registered($user = User::create($data)));

        return $user;
    }
}
