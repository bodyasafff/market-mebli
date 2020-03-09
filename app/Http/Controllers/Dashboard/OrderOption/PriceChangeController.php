<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\PaymentStatus;
use App\Models\Orders\PriceChange;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class PriceChangeController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.price-change.index');
    }

    public function indexJson(Request $request)
    {
        $model = PriceChange::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new PriceChange();
        return view('dashboard.order-option.price-change.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new PriceChange();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.price_change.index');
    }

    public function edit(PriceChange $model)
    {
        return view('dashboard.order-option.price-change.edit',compact('model'));
    }

    public function update(Request $request,PriceChange $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.price_change.index');
    }

    public function destroy(PriceChange $model)
    {
        $model->delete();
        return view('dashboard.order-option.price-change.index');
    }
}
