<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\DataProduct;
use App\Models\Product;
use App\Models\ProductCategory;

use App\Repositories\Dashboard\ProductControllerRepository;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades;
use Intervention\Image\ImageManagerStatic as Image;
use DataTables;


class ProductController extends Controller
{
    public function index()
    {
        $model = Product::first();
        dd($model);
    }

    public function store(Request $request)
    {
    }

    public function create()
    {
    }

    public function edit(Product $model)
    {
    }

    public function update(Request $request, Product $model)
    {
    }
}
