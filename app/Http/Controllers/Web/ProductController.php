<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\WebController;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Dashboard\Product\StoreRequest;
use App\Models\DataProduct;
use App\Models\Datasets\Lang;
use App\Models\Product;
use App\Models\Property;
use App\Repositories\Base\FileRepository;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades;
use Intervention\Image\ImageManagerStatic as Image;
use DataTables;


class ProductController extends WebController
{
    public function index($modelId)
    {

        if(!$model = Product::with([
        'data_product' => function($q){},
        'properties' => function($q){
           $q->with([
               'property_category' => function($q){
                   $q->with([
                       'group' => function($q){
                        }
                   ]);
               }
           ]);
        }])->where('id', $modelId)->first()){
            abort(404);
        }

        $collection = collect($model->properties)->sortBy('property_category.group.value')->reverse()->groupBy('property_category.group.id');

        $collection->transform(function ($item){
            $item = collect($item)->sortBy('property_category.weight')->reverse()->groupBy('property_category.id');
            $item->transform(function ($i){
                $i = collect($i)->sortBy('weight')->reverse();
                return $i;
            });
            return $item;
        });

        $collection->transform(function ($item){
            $item->transform(function ($i){
                $i['name'] = $i->first()->property_category->name_ua;
                return $i;
            });
            $item['name'] = $item->first()->first()->property_category->group->name;
            return $item;
        });
        return view('web.product.details', ['product' => $model,'properties' => $collection]);
    }
}
