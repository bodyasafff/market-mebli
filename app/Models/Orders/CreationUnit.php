<?php

namespace App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orders\CreationUnit selectAll()
 */
class CreationUnit extends ModelBase
{
    protected $table = 'creation_units';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
    ];
}