<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'shops';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $fillable=[
        'user_id',
        'name',
        'logo_company',
        'slug',
        'description',
        'home_no',
        'street_no',
        'villag',
        'location',
        'distric',
        'commun',
        'provinc',
        'status',
        'phone_one',
        'phone_two',
        'email',
        'facebook',
        'wechat',
        'website',
        'updated_by'
    ];
}
