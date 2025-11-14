<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        'updated_by',
    ];
protected static function boot()
    {
        parent::boot();

        // នៅពេលដែល Model ត្រូវបានលុបជាអចិន្ត្រៃយ៍ (forceDelete)
        static::forceDeleted(function ($slider) {
            // ពិនិត្យមើលថាតើមានឈ្មោះរូបភាពក្នុង database ដែរឬទេ
            if ($slider->image_slider) {
                // លុបឯកសារចេញពី public disk
                // ផ្លូវនឹងត្រូវមើលទៅដូចជា៖ 'images/sliders/filename.jpg'
                Storage::disk('public')->delete($slider->image_slider);
            }
        });
    }
}
