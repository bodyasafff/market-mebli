<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Dashboard\Product\StoreRequest;
use App\Models\DataProduct;
use App\Models\Datasets\Lang;
use App\Models\Product;
use App\Models\Property;
use App\Repositories\Base\FileRepository;
use GuzzleHttp\Psr7\Uri;
use http\Url;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades;
use Intervention\Image\ImageManagerStatic as Image;
use DataTables;


class OrderController extends DashboardController
{
    public function index()
    {
        return view('dashboard.order.index');
    }

    public function indexJson(Request $request)
    {
        $model = Order::with([
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
        ]);
        return datatables()->eloquent($model)->toJson();
    }

    public function detail($model)
    {
        $model = Order::where('id',$model)->with([
            'products' => function ($q) {
                $q->select(['id','image', 'name_ua']);
            },
            'client' => function($q){
                $q->select(['id','name','surname','middle_name','phone']);
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
            }
        ])->first();
        return view('dashboard.order.detail',compact('model'));
    }

    public function storeProduct(Request $request)
    {
        $model = new Product();
        foreach (Lang::all() as $lang){
            $model->{'name_'.$lang['id']} = $request->{'name_'.$lang['id']};
        }
        $model->product_category_id = $request->product_category_id;
        $model->save();
        $model->properties()->sync($request->properties);
        $dataProduct = new DataProduct();
        $dataProduct->id = $model->id;
        foreach (Lang::all() as $lang){
            $dataProduct->{'description_'.$lang['id']} = $request->{'description_'.$lang['id']};
        }
        $dataProduct->notes = $request->notes;
        $dataProduct->save();
        return redirect()->back();
    }

    public function storeClient(Request $request)
    {
        $model = new Client();
        $model->name = $request->name;
        $model->surname = $request->surname;
        $model->middle_name = $request->middle_name;
        $model->country = $request->country;
        $model->city = $request->city;
        $model->street = $request->street;
        $model->house = $request->house;
        $model->save();
        return redirect()->back();
    }

    public function create()
    {
        $model = new Order();
        return view('dashboard.order.edit',compact('model'));
    }

    public function store(Request $request)
    {
        $model = new Order();
        $this->save($request,$model);
        return redirect()->route('dashboard.order.index');
    }

    public function edit(Order $model)
    {
        return view('dashboard.order.edit',compact('model'));
    }

    public function update(Request $request,Order $model)
    {
        $this->save($request,$model);
        return redirect()->route('dashboard.order.index');
    }

    public function destroy(Order $model)
    {
        $model->delete();
        return redirect()->route('dashboard.order.index');
    }

    public function save(Request $request,Order $model)
    {
        $model->return_location_id = $request->return_location_id;
        $model->client_status_id = $request->client_status_id;
        $model->delivery_status_id = $request->delivery_status_id;
        $model->delivery_id = $request->delivery_id;
        $model->client_id = $request->client_id;
        $model->product_location_id = $request->product_location_id;
        $model->payment_method_id = $request->payment_method_id;
        $model->payment_status_id = $request->payment_status_id;
        $model->creation_unit_id = $request->creation_unit_id;
        $model->state_id = $request->state_id;
        $model->order_status_id = $request->order_status_id;

        $model->price_producer = $request->price_producer;
        $model->price_change_id = $request->price_change_id;
        $model->date_payment = $request->date_payment;
        $model->payment_document_text = $request->payment_document;
        $model->date_departure = $request->date_departure;
        $model->date_arrival = $request->date_arrival;


        if($request->hasFile('payment_document_file')){
            $typeFile = explode('.',$request->payment_document_file->getClientOriginalName());
            $typeFile = last($typeFile);
            $file_path = 'storage/' . $model->payment_document_file;
            if (Facades\File::exists($file_path)) {
                Facades\File::delete($file_path);
            }
            $fileName = FileRepository::getRandomName($typeFile);
            Storage::disk('public')->put($fileName, (string)$request->file('payment_document_file')->get());
            $model->payment_document_file = $fileName;
        }

        $model->save();

        if($request->release_order_products) {
            $products = explode(',', $request->release_order_products);
            for ($i = 0; $i < count($products); $i++) {
                $products[$i] = ['product_id' => $products[$i], 'count' => $request->{'count_product_' . $products[$i]}];
            }
            $model->products()->sync($products);
        }
    }
     public function downloadPaymentDocument(Order $model)
     {
         return response()->download(public_path('storage/'.$model->payment_document_file));
     }
}