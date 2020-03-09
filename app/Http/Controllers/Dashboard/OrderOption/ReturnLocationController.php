<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\ReturnLocation;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class ReturnLocationController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.return-location.index');
    }

    public function indexJson(Request $request)
    {
        $model = ReturnLocation::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new ReturnLocation();
        return view('dashboard.order-option.return-location.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new ReturnLocation();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.return_location.index');
    }

    public function edit(ReturnLocation $model)
    {
        return view('dashboard.order-option.return-location.edit',compact('model'));
    }

    public function update(Request $request,ReturnLocation $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.return_location.index');
    }

    public function destroy(ReturnLocation $model)
    {
        $model->delete();
        return view('dashboard.order-option.return-location.index');
    }

}
