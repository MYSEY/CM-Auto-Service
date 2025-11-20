<?php

namespace App\Models;

use App\Models\Engine;
use App\Models\ProductType;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
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
        'product_type_id',
        'category_id',
        'sub_category_id',
        'view_counter',
        'name',
        'description',
        'product_photo',
        'price',
        'year',
        'engine_id',
        'discount_price',
        'number',
        'slug',
        'publish',
        'status',
        'created_by',
        'updated_by'
    ];
    public function category(){
        return $this->belongsTo(ProductCategory::class,'category_id');
    }
    public function subCategory(){
        return $this->belongsTo(ProductSubCategory::class,'sub_category_id');
    }
    public function proEngine(){
        return $this->belongsTo(Engine::class,'engine_id');
    }
    public function productImage(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
    public function productType(){
        return $this->belongsTo(ProductType::class,'product_type_id');
    }
    public function getPriceFormatAttribute(){
        return "$"." ".number_format($this->price,2);
    }
    public function getDiscountPriceFormatAttribute(){
        return "$"." ".number_format($this->discount_price,2);
    }
}
