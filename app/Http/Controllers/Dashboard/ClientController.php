<?php

namespace App\Http\Controllers\Dashboard;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Google\SeoArticleRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class ClientController extends DashboardController
{
    public function index()
    {
        return view('dashboard.client.index');
    }

    public function indexJson(Request $request)
    {
        $model = Client::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function orderDetail($orderId)
    {
        $model = Order::where('id', $orderId)->with([
        'products' => function ($q) {
            $q->select(['id','image', 'name_ua']);
        },
        'client' => function($q){
            $q->select(['id','name','surname','phone']);
        },
        'creation_unit' => function($q){
            $q->select(['id','name']);
        },
        'payment_status' => function($q){
            $q->select(['id','name']);
        },
        'return_location' => function($q){
            $q->select(['id','name']);
        },
            'client_status' => function($q){
                $q->select(['id','name']);
            },
            'delivery_status' => function($q){
                $q->select(['id','name']);
            },
            'delivery' => function($q){
                $q->select(['id','name']);
            },
            'product_location' => function($q){
                $q->select(['id','name']);
            },
            'payment_method' => function($q){
                $q->select(['id','name']);
            },
            'state' => function($q){
                $q->select(['id','name']);
            },
            'order_status' => function($q){
                $q->select(['id','name']);
            }

        ])->first();
        return $model->toJson();
    }

    public  function detailJson(Request $request)
    {
        $clientId = 1;
        $model = Order::where('client_id',$request->columns[$clientId]['name'])->with([
            'products' => function ($q) {
                $q->select(['id','image', 'name_ua']);
            },
            'client' => function($q){
                $q->select(['id','name','surname','phone']);
            },
            'creation_unit' => function($q){
                $q->select(['id','name']);
            },
            'payment_status' => function($q){
                $q->select(['id','name']);
            }
        ]);;
        self::datatablesRemoveColumns($request,[
            $clientId,
        ]);
        return datatables()->eloquent($model)->toJson();
    }

    public function detail(Client $model)
    {
        return view('dashboard.client.detail',compact('model'));
    }

    public function create()
    {
        $model = new Client();
        return view('dashboard.client.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new Client();
        $model->name = $request->name;
        $model->surname = $request->surname;
        $model->middle_name = $request->middle_name;
        $model->phone = $request->phone;
        $model->country = $request->country;
        $model->city = $request->city;
        $model->street = $request->street;
        $model->house = $request->house;
        $model->save();
        return redirect()->route('dashboard.client.index');
    }

    public function edit(Client $model)
    {
        return view('dashboard.client.edit',compact('model'));
    }

    public function update(Request $request,Client $model)
    {
        $model->name = $request->name;
        $model->surname = $request->surname;
        $model->middle_name = $request->middle_name;
        $model->phone = $request->phone;
        $model->country = $request->country;
        $model->city = $request->city;
        $model->street = $request->street;
        $model->house = $request->house;
        $model->save();
        return redirect()->route('dashboard.client.index');
    }

    public function destroy(Client $model)
    {
        $model->delete();
        return view('dashboard.client.index');
    }
}
