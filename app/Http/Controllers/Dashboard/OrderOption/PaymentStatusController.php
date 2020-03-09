<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\PaymentStatus;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class PaymentStatusController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.payment-status.index');
    }

    public function indexJson(Request $request)
    {
        $model = PaymentStatus::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new PaymentStatus();
        return view('dashboard.order-option.payment-status.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new PaymentStatus();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.payment_status.index');
    }

    public function edit(PaymentStatus $model)
    {
        return view('dashboard.order-option.payment-status.edit',compact('model'));
    }

    public function update(Request $request,PaymentStatus $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.payment_status.index');
    }

    public function destroy(PaymentStatus $model)
    {
        $model->delete();
        return view('dashboard.order-option.payment-status.index');
    }
}
