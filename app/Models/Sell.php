<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sell extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'customer_name',
        'invoice_no',
        'sell_date',
        'total_amount',
        'grand_total',
        'paid_amount',
        'due_amount',
        'status',
        'remark',
        'created_by',
        'updated_by'
    ];

    public function details() {
        return $this->hasMany(SellDetail::class);
    }
}
