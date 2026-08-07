<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatBotResponse extends Model
{
    protected $fillable = ['keyword', 'response', 'is_active'];

    public $timestamps = true;
}
