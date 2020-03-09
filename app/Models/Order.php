<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product selectAll()
 */
class Order extends ModelBase
{
    protected $table = 'orders';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'int',
        'product_category_id' => 'int',
        'sale_id' => 'int',
    ];

    protected $fillable = [
        'created_at',
        'return_location_id',
        'client_status_id',
        'delivery_status_id',
        'delivery_id',
        'client_id',
        'product_location_id',
        'payment_status_id',
        'state_id',
        'creation_unit_id',
        'state',
        'price_producer',
        'price_change',
        'payment_method',
        'date_payment',
        'payment_document',
        'date_departure',
        'date_arrival',
        'order_status_id'
    ];

    public function price_change()
    {
        return $this->hasOne('App\Models\Orders\PriceChange','id','price_change_id');
    }

    public function payment_status()
    {
        return $this->hasOne('App\Models\Orders\PaymentStatus','id','payment_status_id');
    }

    public function order_status()
    {
        return $this->hasOne('App\Models\Orders\OrderStatus','id','order_status_id');
    }

    public function payment_method()
    {
        return $this->hasOne('App\Models\Orders\PaymentMethod','id','payment_method_id');
    }

    public function product_location()
    {
        return $this->hasOne('App\Models\Orders\ProductLocation','id','product_location_id');
    }

    public function creation_unit()
    {
        return $this->hasOne('App\Models\Orders\CreationUnit','id','creation_unit_id');
    }

    public function delivery_status()
    {
        return $this->hasOne('App\Models\Orders\DeliveryStatus','id','delivery_status_id');
    }

    public function client_status()
    {
        return $this->hasOne('App\Models\Orders\ClientStatus','id','client_status_id');
    }

    public function return_location()
    {
        return $this->hasOne('App\Models\Orders\ReturnLocation','id','return_location_id');
    }

    public function state()
    {
        return $this->hasOne('App\Models\Orders\State','id','state_id');
    }

    public function delivery()
    {
        return $this->hasOne('App\Models\Orders\Delivery','id','delivery_id');
    }

    public function client()
    {
        return $this->hasOne('App\Models\Client','id','client_id');
    }

    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class,'order_product','order_id','product_id')
            ->withPivot('count');
    }
}