<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\PaymentMethod;
use App\Models\Orders\PaymentStatus;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class PaymentMethodController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.payment-method.index');
    }

    public function indexJson(Request $request)
    {
        $model = PaymentMethod::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new PaymentMethod();
        return view('dashboard.order-option.payment-method.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new PaymentMethod();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.payment_method.index');
    }

    public function edit(PaymentMethod $model)
    {
        return view('dashboard.order-option.payment-method.edit',compact('model'));
    }

    public function update(Request $request,PaymentMethod $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.payment_method.index');
    }

    public function destroy(PaymentMethod $model)
    {
        $model->delete();
        return view('dashboard.order-option.payment-method.index');
    }
}
