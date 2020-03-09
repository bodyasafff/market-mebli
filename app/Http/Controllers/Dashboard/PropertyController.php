<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Property\StoreRequest;
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

class PropertyController extends DashboardController
{
    public function index()
    {
        return view('dashboard.property.index');
    }
    public function indexJson(Request $request){
        $model = Property::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function store(StoreRequest $request)
    {
        $model = new Property();
        self::save($request,$model);
        return redirect()->route('dashboard.property.index');
    }

    public function create()
    {
        $model = new Property();
        return view('dashboard.property.edit',compact('model'));
    }

    public function edit(Property $model)
    {
        return view('dashboard.property.edit',compact('model'));
    }

    public function update(Request $request, Property $model)
    {
        self::save($request,$model);
        return redirect()->route('dashboard.property.index');
    }

    public function destroy(Property $model)
    {
        $model->delete();
        return redirect()->route('dashboard.property.index');
    }

    static function save(Request $request,Property $model){
        foreach (Lang::all() as $lang){
            $model->{'name_'.$lang['id']} = $request->{'name_'.$lang['id']};
        }
        $model->property_category_id = $request->property_category_id;
        $model->weight = $request->weight;
        $model->save();
    }

}
