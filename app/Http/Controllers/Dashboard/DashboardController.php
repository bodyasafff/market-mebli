<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DashboardController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

    }

    static function datatablesRemoveColumns(&$request, $columnIds = [])
    {
        foreach ($columnIds as $columnId){
            $requestColumns = $request->columns;
            $requestColumns[$columnId]['search']['value'] = null;
            $request->merge([
                'columns' => $requestColumns
            ]);
        }
    }
}
