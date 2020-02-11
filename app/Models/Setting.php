<?php

namespace App\Models;

use App\AppConf;
use App\Application;
use Exception;

/**
 * Class Setting
 *
 * @property string $id
 * @property string $value
 * @property string $value_default
 * @property string $description
 * @property \Carbon\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 *
 * @package App\Models
 */
class Setting extends ModelBase
{
    protected $table = 'settings';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'value',
        'value_default',
        'description'
    ];

    protected $attributes = [
        'value'         => 0,
        'value_default' => 0,
    ];

    //--------------------------------------

    static function getValue($id)
    {
        try{
            if ($value = self::whereId($id)->first()) {
                return $value->value;
            }
        }catch (Exception $e){
            echo "\nERROR CHECK SETTINGS \n\n";
            sleep(10);
            if ($value = self::whereId($id)->first()) {
                return $value->value;
            }
        }

        self::create([
            'id' => $id
        ]);
        return 0;
    }

    static function checkValue($id, $value, $equal = true)
    {
        $isValue = self::getValue($id);
        return $equal ? $isValue == $value : $isValue != $value;
    }

    static function updateValue($id, $value)
    {
        self::updateOrCreate([
            'id' => $id,
        ], [
            'value' => $value,
            'description' => !empty(Application::$procId) && !empty($value) ? Application::getDescriptionServer() : '',
        ]);
    }

    static function consoleProcFlag($procId = null, $procNum = null)
    {
        $procId = !empty($procId) ? $procId : Application::$procId;
        $procNum = !empty($procNum) ? $procNum : Application::$procNum;

        return 'is_console_proc_'.$procId.'_'.$procNum.'_run';
    }

    static function consoleProcLastId($procId = null, $procNum = null)
    {
        $procId = !empty($procId) ? $procId : Application::$procId;
        $procNum = !empty($procNum) ? $procNum : Application::$procNum;

        return 'console_proc_'.$procId.'_'.$procNum.'_last_id';
    }
}
