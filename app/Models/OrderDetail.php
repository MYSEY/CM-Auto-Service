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
        'quantity',
        'price',
        'sub_total',
        'created_by',
        'updated_by'
    ];
}
