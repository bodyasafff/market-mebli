<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\ReturnLocation;
use App\Models\Orders\State;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class StateController extends DashboardController
{
    public function index(){
        return view('dashboard.order-option.state.index');
    }

    public function indexJson(Request $request)
    {
        $model = State::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new State();
        return view('dashboard.order-option.state.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new State();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.state.index');
    }

    public function edit(State $model)
    {
        return view('dashboard.order-option.state.edit',compact('model'));
    }

    public function update(Request $request,State $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.state.index');
    }

    public function destroy(State $model)
    {
        $model->delete();
        return view('dashboard.order-option.state.index');
    }

}
