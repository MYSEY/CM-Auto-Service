<?php

namespace App\Models;

use App\Models\ProductSubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Engine extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'engines';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'sub_category_id',
        'name',
        'category_id',
        'part_number',
        'slug',
        'created_by',
        'updated_by'
    ];

  public function category(){
        return $this->belongsTo(ProductCategory::class,'category_id');
    }
    public function subCategory(){
        return $this->belongsTo(ProductSubCategory::class,'sub_category_id');
    }

}
