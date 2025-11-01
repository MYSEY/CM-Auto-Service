<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductStatus extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'product_statuses';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'name',
        'description',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
