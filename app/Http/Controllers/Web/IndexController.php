<?php

namespace App\Http\Controllers\Web;

use App;

class IndexController extends WebController
{
    public function index()
    {
        return view('web.index');
    }
}
