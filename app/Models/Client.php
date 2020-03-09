<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client selectAll()
 */
class Client extends ModelBase
{
    protected $table = 'clients';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'surname',
        'middle_name',
        'phone',
        'country',
        'city',
        'street',
        'house'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order','client_id','id');
    }
}