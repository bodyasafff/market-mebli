<?php

namespace App\Models\Datasets;

use App\AppConf;
use App\Repositories\Google\GTrends;

/**
 * Class ProcessList
 */
class ProcessList extends Dataset
{
    static function checkEnv($id)
    {
        $settings = ProcessList::findById($id);
        $procEnv = $settings['env'];
        $tagVersion = $settings['tagVersion'];
        return true;
    }

    static function getResultFromApiResponse($response)
    {


    }

    static $data = [
       [
            'id' => 1,
            'name' => 'C1 Test',
            'count' => 1,
            'env' => '',
            'group' => 1,
            'tagVersion' => '',
        ]
    ];
}