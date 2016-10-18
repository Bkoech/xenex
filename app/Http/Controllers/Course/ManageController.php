<?php

namespace Xenex\Http\Controllers\Course;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Xenex\Http\Requests;
use Xenex\Http\Controllers\Controller;
use Xenex\Components\Course\Manage\Service as ManageService;

class ManageController extends Controller
{
    protected $view = 'course.manage';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCourse(): View
    {
        $service = new ManageService();
        return view($this->view ?? 'course.manage')
                ->with('courses', $service->action());
    }
}
