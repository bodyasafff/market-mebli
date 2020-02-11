<?php

namespace App\Http\Controllers\Api;

use App\Application;
use App\Models\Datasets\ProcessList;
use App\Models\Setting;
use Illuminate\Http\Request;

class IndexController extends ApiController
{
    public function apiVersion()
    {
        //TODO:version

        return $this->respondContent('0.0.1');
    }
}
