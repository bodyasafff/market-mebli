<?php

namespace App\Http\Controllers\Web;


use App\Http\Requests\Dashboard\ProductCategory\StoreRequest;
use App\Models\Datasets\Lang;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Repositories\Base\FileRepository;
use Illuminate\Http\Request;


class ProductCategoryController extends WebController
{
    public function index($modelId){


        if(!$model = ProductCategory::where('id',$modelId)
            ->with([
                'property_categories' => function($q){
                    $q->orderBy('weight','desc');
                }
            ])
            ->first()){
            abort(404);
        }
        $products = $model->products;
        return view('web.product-category.index',compact('products','model'));
    }

    public function indexSort($productCategoryId,$idChekBoxes)
    {
        if(!$model = ProductCategory::where('id',$productCategoryId)
            ->with([
            'property_categories' => function($q){
                $q->orderBy('weight');
            }
        ])
            ->first()){
            abort(404);
        }

        $properties = explode(',', $idChekBoxes);
        $products = Product::where('product_category_id',$productCategoryId);
        foreach ($properties as $item) {
            $products->whereHas('properties', function ($query) use ($item) {
                $query->where('id', $item);
            });
        }

        $products = $products->get();
        return view('web.product-category.index',compact('products','model','idChekBoxes'));
    }

}
