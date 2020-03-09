<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group selectAll()
 */
class Group extends ModelBase
{
    protected $table = 'groups';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'value'
    ];
}