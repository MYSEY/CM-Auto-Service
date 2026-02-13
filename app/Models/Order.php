<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'name',
        'telephone',
        'email',
        'total_price',
        'total_qty',
        'total_discount',
        'order_date',
        'status',
        'created_by',
        'updated_by'
    ];
}
