<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'order_id',
        'product_id',
        'product_type_id',
        'category_id',
        'sub_category_id',
        'engine_id',
        'quantity',
        'price',
        'total_price',
        'discount',
        'created_by',
        'updated_by'
    ];
}
