<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'invoice_code',
        'name',
        'qty',
        'price',
        'subtotal',
    ];
}
