<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\Delivery;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class DeliveryController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.delivery.index');
    }

    public function indexJson(Request $request)
    {
        $model = Delivery::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new Delivery();
        return view('dashboard.order-option.delivery.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new Delivery();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.delivery.index');
    }

    public function edit(Delivery $model)
    {
        return view('dashboard.order-option.delivery.edit',compact('model'));
    }

    public function update(Request $request,Delivery $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.delivery.index');
    }

    public function destroy(Delivery $model)
    {
        $model->delete();
        return view('dashboard.order-option.delivery.index');
    }

}
