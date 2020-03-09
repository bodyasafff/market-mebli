<?php

namespace App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orders\OrderStatus selectAll()
 */
class OrderStatus extends ModelBase
{
    protected $table = 'order_statuses';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
    ];
}