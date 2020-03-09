<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Requests\Dashboard\PropertyCategory\StoreRequest;
use App\Models\Datasets\Lang;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Repositories\Base\FileRepository;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class PropertyCategoryController extends DashboardController
{
    public function index()
    {
        return view('dashboard.property-category.index');
    }

    public function indexJson(Request $request)
    {
        $property_category_ids = 1;

        $property_categories = explode(',', $request->columns[$property_category_ids]['search']['value']);

        if($request->columns[$property_category_ids]['search']['value'])
        {
            $model = PropertyCategory::whereHas('product_categories',function ($query) use($property_categories){
                $query->whereIn('id', $property_categories);
            });
        }else{
            $model = PropertyCategory::selectAll();
        }

        self::datatablesRemoveColumns($request,[
            $property_category_ids
        ]);
        return datatables()->eloquent($model)->toJson();
    }

    public function create()
    {
        $model = new PropertyCategory();
        return view('dashboard.property-category.edit',compact('model'));
    }

    public function store(StoreRequest $request)
    {
        $model = new PropertyCategory();
        self::save($request,$model);
        return redirect()->route('dashboard.property-category.index');
    }

    public function edit(PropertyCategory $model)
    {
        return view('dashboard.property-category.edit',compact('model'));
    }

    public function update(PropertyCategory $model,StoreRequest $request)
    {
        self::save($request,$model);
        return redirect()->route('dashboard.property-category.index');
    }

    public function destroy(PropertyCategory $model)
    {
        $model->delete();
        return redirect()->route('dashboard.property-category.index');
    }

    static function save(Request $request,PropertyCategory $model){
        $model->group_id = $request->group_id;
        $model->parent_property_category_id = $request->parent_property_category_id;
        $model->weight = $request->weight;
        foreach (Lang::all() as $lang){
            $model->{'name_'.$lang['id']} = $request->{'name_'.$lang['id']};
        }
        $model->save();
    }
}