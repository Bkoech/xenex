<?php

namespace Xenex\Components\Course\Create;

use Validator;
use Xenex\Course\Course;

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
        return Course::create($data);
    }
}