<?php

namespace App\Http\Controllers\Dashboard;

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


class ProductController extends DashboardController
{
    public function index()
    {
        return view('dashboard.product.index');
    }

    public function indexJson(Request $request){

        $property_ids = 1;
        $property_only_ids = 2;
        $properties = explode(',', $request->columns[$property_ids]['search']['value']);
        $properties_only = explode(',', $request->columns[$property_only_ids]['search']['value']);

        $model = Product::selectAll();
        if($request->columns[$property_ids]['search']['value'])
        {
            $model->whereHas('properties',function ($query) use($properties){
                $query->whereIn('id', $properties);
            })->with(['product_category' => function ($q) {
                $q->select(['id', 'name_ua']);
            }]);
        }
        if($request->columns[$property_only_ids]['search']['value']) {

            foreach ($properties_only as $item) {
                $model->whereHas('properties',function ($query) use($item){
                    $query->where('id', $item);
                });
            }
            $model->with(['product_category' => function ($q) {
                $q->select(['id', 'name_ua']);
            }]);
        }

        self::datatablesRemoveColumns($request,[
            $property_ids,
            $property_only_ids
        ]);
        return datatables()->eloquent($model)->toJson();
    }

    public function store(StoreRequest $request)
    {

        $model = new Product;
        $this->save($request,$model);
        $dataProduct = new DataProduct();
        $dataProduct->id = $model->id;
        self::saveDateProduct($request,$dataProduct);
        return redirect()->route('dashboard.product.index');
    }

    public function create()
    {
        $model = new Product();
        return view('dashboard.product.edit',compact('model'));
    }

    public function edit(Product $model)
    {
        return view('dashboard.product.edit',compact('model'));
    }

    public function update(Request $request, Product $model)
    {
        $this->save($request,$model);
        self::saveDateProduct($request,$model->data_product);
        return redirect()->route('dashboard.product.index');
    }

    public function destroy(Product $model)
    {
        $image_path = 'storage/'.$model->image;
        if(Facades\File::exists($image_path)) {
            Facades\File::delete($image_path);
        }
        foreach ($model->data_product->images as $image){
            $image_path = 'storage/'.$image;
            if(Facades\File::exists($image_path)) {
                Facades\File::delete($image_path);
            }
        }

        $model->delete();
        return redirect()->route('dashboard.product.index');
    }

    public function save(Request $request,Product $model)
    {
        $request->availability_in_stock?$model->availability_in_stock = 1:$model->availability_in_stock = 0;
        foreach (Lang::all() as $lang){
            $model->{'name_'.$lang['id']} = $request->{'name_'.$lang['id']};
        }
        $model->price = $request->price;
        $model->product_category_id = $request->product_category_id;
        self::saveFileImage($model,$request);
//        self::saveMainImage($model,$request);
        $model->save();
        $model->properties()->sync($request->properties);

    }



    static function saveDateProduct(Request $request, DataProduct $model)
    {

        foreach (Lang::all() as $lang){
            $model->{'description_'.$lang['id']} = $request->{'description_'.$lang['id']};
        }
        $model->notes = $request->notes;
        self::dateProductImages($model,$request);



        //self::saveImageToDataProduct($model, $request);
        $model->save();
    }


    static function dateProductImages($model, $request){
        $temp = $model->images;
        if($temp) {
            $delImages = explode(',', $request->images_deleted);
            for ($i = 0; $i < count($delImages); $i++) {
                for ($j = 0; $j < count($temp); $j++) {
                    if (url('') . '/storage/' . $temp[$j] == $delImages[$i]) {
                        $image_path = 'storage/' . $temp[$j];
                        if (Facades\File::exists($image_path)) {
                            Facades\File::delete($image_path);
                        }
                        array_splice($temp, $j, 1);
                    }
                }
            }
        }

        if($request->images) {
//            $count = count($model->images);
//            for ($i = 0; $i < count($request->images); $i++) {
//                array_push($temp, '');
//            }

            foreach ($request->images as $image) {
                $imageName = FileRepository::getRandomName('jpg');
                $image = $image;
                try {
                    $image = Image::make($image)->orientate()->encode('jpg', 60);
                } catch (\Exception $e) {
                    dd($e->getMessage(), $image);
                }

                Storage::disk('public')->put($imageName, (string)$image);
                array_push($temp , $imageName);
//                $count++;
            }
        }
        $model->images = $temp;
    }




//    static function saveMainImage($model, $request){
//        if($request->immmages) {
//            foreach ($request->images as $image) {
//                $imageName = FileRepository::getRandomName('jpg');
//                $image = $image;
//                $image = Image::make($image)->orientate()->encode('jpg', 60);
//                Storage::disk('public')->put($imageName, (string)$image);
//                $model->image = $imageName;
//                break;
//            }
//        }
//    }




    //-------------------------------------------------
    static function saveFileImage($model, $request)
    {
        $is_delete = explode(',',$request->images_deleted);

        if($model->image) {
            for ($j = 0; $j < count($is_delete); $j++) {
                if ($is_delete[$j] == url('') . '/storage/' . $model->image) {
                    $image_path = 'storage/' . $model->image;
                    if (Facades\File::exists($image_path)) {
                        Facades\File::delete($image_path);
                    }
                    $model->image = '';
                }
            }
        }

        if($request->hasFile('image')) {
            $image_path = 'storage/' . $model->image;
            if (Facades\File::exists($image_path)) {
                Facades\File::delete($image_path);
            }
            $imageName = FileRepository::getRandomName('jpg');
            $image = $request->file('image');
            $image = Image::make($image)->orientate()->encode('jpg', 60);
            Storage::disk('public')->put($imageName, (string)$image);
            $model->image = $imageName;
        }
    }


    static function saveImageToDataProduct($model, $request, $fieldName = 'images')
    {

        $is_delete = explode(',',$request->images_deleted);
        $modelImages = $model->{$fieldName};
        if(empty($modelImages)){
            $modelImages = ['',''];
        }

        for ($i = 0; $i < DataProduct::IMAGES_COUNT; $i++) {
            if($model->images) {
                for ($j = 0; $j < count($is_delete); $j++) {
                    if ($is_delete[$j] == url('') . '/storage/' . $model->{$fieldName}[$i]) {
                        $image_path = 'storage/' . $model->{$fieldName}[$i];
                        if (Facades\File::exists($image_path)) {
                            Facades\File::delete($image_path);
                        }
                        $modelImages[$i] = '';
                    }
                }
            }
            if($request->hasFile($fieldName.'_'.$i)) {
                $imageName = FileRepository::getRandomName('jpg');
                $image = $request->file($fieldName.'_' . $i);
                try{
                    $image = Image::make($image)->orientate()->encode('jpg', 60);
                }catch (\Exception $e){
                    dd($e->getMessage(), $fieldName.'_' . $i, $image);
                }

                Storage::disk('public')->put($imageName, (string)$image);

                if(!empty($model->{$fieldName}[$i])) {
                    if ($model->{$fieldName}[$i]) {
                        $imagePaths = 'storage/' . $model->{$fieldName}[$i];
                        if (Facades\File::exists($imagePaths)) {
                            Facades\File::delete($imagePaths);
                        }
                    }
                }
                $modelImages[$i] = $imageName;

            }
        }
        $model->{$fieldName} = $modelImages;
    }
}
