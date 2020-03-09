<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\ProductLocation;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class ProductLocationController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.product-location.index');
    }

    public function indexJson(Request $request)
    {
        $model = ProductLocation::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new ProductLocation();
        return view('dashboard.order-option.product-location.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new ProductLocation();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.product_location.index');
    }

    public function edit(ProductLocation $model)
    {
        return view('dashboard.order-option.product-location.edit',compact('model'));
    }

    public function update(Request $request,ProductLocation $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.product_location.index');
    }

    public function destroy(ProductLocation $model)
    {
        $model->delete();
        return view('dashboard.order-option.product-location.index');
    }
}
