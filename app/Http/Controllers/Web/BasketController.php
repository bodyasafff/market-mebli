<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\WebController;
use App\Models\ProductCategory;
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


class BasketController extends WebController
{
    public function index($productsId)
    {
        $productsId = explode(',', $productsId);
        if (!empty($productsId)) {
            $products = collect([]);
            foreach ($productsId as $id) {
                $products->push(Product::where('id', $id)->first());
            }
        }
        return $products->toJson();
    }
}
