<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\ClientStatus;
use App\Models\Orders\OrderStatus;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class OrderStatusController extends DashboardController
{
    public function index()
    {
        return view('dashboard.order-option.order-status.index');
    }

    public function indexJson(Request $request)
    {
        $model = OrderStatus::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new OrderStatus();
        return view('dashboard.order-option.order-status.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new OrderStatus();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.order_status.index');
    }

    public function edit(OrderStatus $model)
    {
        return view('dashboard.order-option.order-status.edit',compact('model'));
    }

    public function update(Request $request,OrderStatus $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.order_status.index');
    }

    public function destroy(OrderStatus $model)
    {
        $model->delete();
        return view('dashboard.order-option.order-status.index');
    }
}
