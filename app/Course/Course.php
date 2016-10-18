<?php

namespace Xenex\Course;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'serial', 'name', 'start_at', 'end_at',
    ];
}
