<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSubCategory extends Model
{
   use HasFactory, SoftDeletes; // Added SoftDeletes to match 'deleted_at' in the schema

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_sub_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'serial_number',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the product category that owns the sub-category.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function subCategory()
    {
        return $this->hasMany(ProductSubCategory::class, 'category_id');
    }
}
