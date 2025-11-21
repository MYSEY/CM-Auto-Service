<?php

namespace App\Models;

use App\Models\ProductSubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_categories';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'name',
        'description',
        'category_photo',
        'slug',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function subCategory()
    {
        return $this->hasMany(ProductSubCategory::class, 'product_category_id','id');
    }
}
