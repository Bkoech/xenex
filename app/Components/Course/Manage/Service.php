<?php

namespace Xenex\Components\Course\Manage;

use Xenex\Course\Course;

class Service
{
    public function __construct()
    {
    }

    public function action()
    {
        return Course::paginate(20);
    }
}