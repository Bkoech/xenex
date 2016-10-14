<?php

namespace Xenex\Components\Auth\Login;

use Auth;
use Cache;
use Validator;

class Service
{
    protected $throttleCount = 10;
    protected $throttleTime = 10;

    public function __construct()
    {
    }

    public function validator(array $data, array $rules): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, $rules);
    }

    public function action(array $credentials, bool $remember)
    {
        if ($this->throttle(sha1($credentials['email']))) {
            throw new TooManyRequestsException();
        }

        if (! Auth::attempt($credentials, $remember)) {
            throw new LoginFailedException();
        }
    }

    protected function throttle(string $hash): bool
    {
        if (! Cache::has($hash)) {
            Cache::put($hash, $this->throttleCount, $this->throttleTime);
        } else {
            Cache::decrement($hash);
        }

        return Cache::get($hash) === 0;
    }
}
