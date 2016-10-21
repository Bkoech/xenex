<?php

namespace Xenex\Http\Controllers\Course;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Xenex\Http\Controllers\Controller;
use Xenex\Components\Course\Create\Service as CreateService;

class CreateController extends Controller
{
    protected $view = 'course.create';
    protected $redirect = '/course';
    protected $validatorRules = [
        'serial' => 'required|max:255',
        'name' => 'required|max:255',
        'start_at' => 'required|max:255|date_format:Y-m-d',
        'end_at' => 'required|max:255|date_format:Y-m-d',
    ];

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
        $service = new CreateService();

        $validator = $service->validator($request->all(), $this->validatorRules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $service->action($request->only(array_keys($this->validatorRules)));
        flash('課程建立成功', 'success');

        return redirect($this->redirect ?? '/course');
    }
}
