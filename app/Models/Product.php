<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'status_id',
        'category_id',
        'view_counter',
        'name',
        'description',
        'product_photo',
        'price',
        'discount_price',
        'delivery_note',
        'content',
        'created_by',
        'updated_by'
    ];
}
