<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
   use HasFactory, SoftDeletes; // 💡 ត្រូវបន្ថែម SoftDeletes trait
   protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'created_by',
        'updated_by',
    ];
/**
     * Get the user who created the contact.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the contact.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
