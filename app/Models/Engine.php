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
        'part_number',
        'slug',
        'created_by',
        'updated_by'
    ];

    public function subCategory(){
        return $this->belongsTo(ProductSubCategory::class,'sub_category_id');
    }
}
