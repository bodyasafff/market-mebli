<?php

namespace App\Http\Controllers\Dashboard;

use App\Application;
use App\Models\DataArticle;
use App\Models\Datasets\ProcessList;
use App\Models\Setting;
use App\Repositories\Base\StringRepository;
use App\Repositories\Google\SeoArticleRepository;
use App\Repositories\Google\SeoRepository;
use Exception;
use Illuminate\Http\Request;

class IndexController extends DashboardController
{
    public function __construct()
    {
        parent::__construct();
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '5000M');
    }

    public function index()
    {
        return view('dashboard.index');
    }

}
