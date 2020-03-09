<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\DeliveryStatus;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class DeliveryStatusController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.delivery-status.index');
    }

    public function indexJson(Request $request)
    {
        $model = DeliveryStatus::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new DeliveryStatus();
        return view('dashboard.order-option.delivery-status.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new DeliveryStatus();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.delivery_status.index');
    }

    public function edit(DeliveryStatus $model)
    {
        return view('dashboard.order-option.delivery-status.edit',compact('model'));
    }

    public function update(Request $request,DeliveryStatus $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.delivery_status.index');
    }

    public function destroy(DeliveryStatus $model)
    {
        $model->delete();
        return view('dashboard.order-option.delivery-status.index');
    }

}
