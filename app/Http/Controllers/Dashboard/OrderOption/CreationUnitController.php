<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\CreationUnit;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class CreationUnitController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.creation-unit.index');
    }

    public function indexJson(Request $request)
    {
        $model = CreationUnit::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new CreationUnit();
        return view('dashboard.order-option.creation-unit.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new CreationUnit();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.creation_unit.index');
    }

    public function edit(CreationUnit $model)
    {
        return view('dashboard.order-option.creation-unit.edit',compact('model'));
    }

    public function update(Request $request,CreationUnit $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.creation_unit.index');
    }

    public function destroy(CreationUnit $model)
    {
        $model->delete();
        return view('dashboard.order-option.creation-unit.index');
    }

}
