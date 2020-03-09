<?php

namespace App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orders\ClientStatus selectAll()
 */
class PaymentMethod extends ModelBase
{
    protected $table = 'payment_methods';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
    ];
}