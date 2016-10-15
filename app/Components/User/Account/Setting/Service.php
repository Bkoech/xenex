<?php

namespace Xenex\Components\User\Account\Setting;

use Auth;
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

    public function action(array $data): array
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->email = $data['email'];
        $user->name = $data['name'];
        $changed = $user->getDirty();
        $user->save();

        return $changed;
    }
}
