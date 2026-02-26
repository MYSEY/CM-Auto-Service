<?php

namespace App\Models;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'product_id',
        'quantity',
        'price',
        'sub_total',
        'order_date',
        'status',
        'created_by',
        'updated_by'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
