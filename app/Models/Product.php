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
        'sub_category_id',
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

    public function getPriceFormatAttribute(){
        return "$"." ".number_format($this->price,2);
    }
    public function getDiscountPriceFormatAttribute(){
        return "$"." ".number_format($this->discount_price,2);
    }
}
