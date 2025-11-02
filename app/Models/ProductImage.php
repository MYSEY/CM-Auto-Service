<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'product_id',
        'path_name',
        'path',
        'created_by',
        'updated_by'
    ];
}
