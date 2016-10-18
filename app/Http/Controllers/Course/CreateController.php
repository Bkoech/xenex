<?php

namespace Xenex\Http\Controllers\Course;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Xenex\Http\Requests;
use Xenex\Http\Controllers\Controller;

class CreateController extends Controller
{
    protected $view = 'course.create';
    protected $redirect = '/course';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCreate(): View
    {
        return view($this->view ?? 'course.create');
    }

    public function postCreate(Request $request): RedirectResponse
    {

    }
}
