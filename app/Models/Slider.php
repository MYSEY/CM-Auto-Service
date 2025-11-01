<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'sliders';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable =[
        'title',
        'image_slider',
        'type',
        'link',
        'created_by',
        'updated_by'
    ];
}
