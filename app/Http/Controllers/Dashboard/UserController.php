<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\User\AjaxUpdateRequest;
use App\Http\Requests\Dashboard\User\StoreRequest;
use App\Models\User;
use App\Repositories\Base\BaseControllerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends DashboardController
{
    public function index()
    {
        return view('dashboard.user.index');
    }

    public function indexJson(Request $request)
    {
        $model = User::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function edit(User $model)
    {
        return view('dashboard.user.edit', compact('model'));
    }

    public function create()
    {
        $model = new User();
        return view('dashboard.user.edit', compact('model'));
    }

    public function store(StoreRequest $request)
    {
        if(empty($request->new_password)){
            $request->new_password = Str::random();
        }

        if ($this->save(new User(), $request)) {
            return redirect()->route('dashboard.user.index');
        }
        return redirect()->back();
    }

    public function update(User $model, StoreRequest $request)
    {
        if ($this->save($model, $request)) {
            return redirect()->route('dashboard.user.index');
        }
        return redirect()->back();
    }

    public function save(User $model, Request $request)
    {
        if(!empty($request->new_password)){
            $model->password = bcrypt($request->new_password);
        }

        return BaseControllerRepository::loadToModelBase($model, $request, [
            'name',
            'email',
            'role_id',
            'status_id',
        ], true, true);
    }

    public function ajaxUpdate(User $model, AjaxUpdateRequest $request)
    {
        if(BaseControllerRepository::loadToModelBase($model, $request, [
            'status_id',
        ], false, true)){
            return 1;
        }
        return 0;
    }

    public function destroy(User $model)
    {
        if ($model->delete()) {
            return redirect()->route('dashboard.user.index');
        }
        return redirect()->back();
    }
}
