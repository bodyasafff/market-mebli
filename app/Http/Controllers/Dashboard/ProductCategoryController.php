<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Requests\Dashboard\ProductCategory\StoreRequest;
use App\Models\Datasets\Lang;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Repositories\Base\FileRepository;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class ProductCategoryController extends DashboardController
{
    public function index(){
        return view('dashboard.product-category.index');
    }

    public function indexJson(Request $request){
        $model = ProductCategory::selectAll();

        return datatables()->eloquent($model)->toJson();
    }

    public function create(){
        $model = new ProductCategory();
        return view('dashboard.product-category.edit',compact('model'));
    }

    public function store(StoreRequest $request)
    {
        $model = new ProductCategory();
        $this->save($request,$model);
        return redirect()->route('dashboard.product-category.index');
    }
    public function destroy(ProductCategory $model){
        $image_path = 'storage/'.$model->image;
        if(Facades\File::exists($image_path)) {
            Facades\File::delete($image_path);
        }
        $model->delete();
        return redirect()->route('dashboard.product-category.index');
    }

    public function edit(ProductCategory $model){
        return view('dashboard.product-category.edit',compact('model'));
    }

    public function update(ProductCategory $model,StoreRequest $request)
    {
        $this->save($request,$model);
        return redirect()->route('dashboard.product-category.index');
    }

    public function save(Request $request,ProductCategory $model){
        foreach (Lang::all() as $lang){
            $model->{'name_'.$lang['id']} = $request->{'name_'.$lang['id']};
        }
        if($request->images_deleted) {
            $image_path = 'storage/'.$model->image;
            if(Facades\File::exists($image_path)) {
                Facades\File::delete($image_path);
            }
            $model->image = '';
        }
        if($request->hasFile('image')){
            $image_path = 'storage/'.$model->image;
            if(Facades\File::exists($image_path)) {
                Facades\File::delete($image_path);
            }
            $imageName = FileRepository::getRandomName('jpg');
            $image = $request->file('image');
            $image = Image::make($image)->orientate()->encode('jpg', 60);
            Storage::disk('public')->put($imageName, (string)$image);
            $model->image = $imageName;
        }
        $model->save();
        $model->property_categories()->sync($request->property_categories);
    }
}
