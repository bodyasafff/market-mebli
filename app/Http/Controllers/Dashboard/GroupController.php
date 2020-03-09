<?php

namespace App\Http\Controllers\Dashboard;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Group;
use App\Models\Orders\ClientStatus;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class GroupController extends DashboardController
{
    public function index()
    {
        return view('dashboard.group.index');
    }

    public function indexJson(Request $request)
    {
        $model = Group::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new Group();
        return view('dashboard.group.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new Group();
        $model->name = $request->name;
        $model->value = $request->value;
        $model->save();
        return redirect()->route('dashboard.group.index');
    }

    public function edit(Group $model)
    {
        return view('dashboard.group.edit',compact('model'));
    }

    public function update(Request $request,Group $model)
    {
        $model->name = $request->name;
        $model->value = $request->value;
        $model->save();
        return redirect()->route('dashboard.group.index');
    }

    public function destroy(Group $model)
    {
        $model->delete();
        return view('dashboard.group.index');
    }
}
