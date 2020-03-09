<?php

namespace App\Http\Controllers\Dashboard\OrderOption;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Orders\ClientStatus;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class ClientStatusController extends DashboardController
{
    public function index()
    {
        return view('dashboard.order-option.status-client.index');
    }

    public function indexJson(Request $request)
    {
        $model = ClientStatus::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new ClientStatus();
        return view('dashboard.order-option.status-client.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new ClientStatus();
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.client_status.index');
    }

    public function edit(ClientStatus $model)
    {
        return view('dashboard.order-option.status-client.edit',compact('model'));
    }

    public function update(Request $request,ClientStatus $model)
    {
        $model->name = $request->name;
        $model->save();
        return redirect()->route('dashboard.order_option.client_status.index');
    }

    public function destroy(ClientStatus $model)
    {
        $model->delete();
        return view('dashboard.order-option.status-client.index');
    }
}
