<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'payment_status',
        'total',
        'shipping_cost',
        'total_tax',
        'grand_total',
        'paid_at',
        'void_at',
        'due_date',
    ];
}
