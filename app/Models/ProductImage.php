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

    /**
     * បង្កើត Accessor សម្រាប់ទាញ URL ពេញពី Cloudflare R2
     * របៀបប្រើក្នុង Blade: $image->full_url
     */
    public function getFullUrlAttribute()
    {
        $baseUrl = "https://pub-9b03345fc5f94d94bdb5bb0b90d3912f.r2.dev/";

        if (!$this->path) {
            return asset('images/default.png');
        }

        // ប្រសិនបើក្នុង DB 'path' មានពាក្យ 'images/products/gallery/'
        // យើងអាចប្រើ Str::replace ដើម្បីសម្អាតវា ឬទុកវានៅដដែលអាស្រ័យលើការ Upload របស់អ្នក
        return $baseUrl . $this->path;
    }
}
