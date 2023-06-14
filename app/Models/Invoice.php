<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'user_id',
        'customer_name',
        'total',
        'created_at',
    ];

    public $incrementing = false;
    protected $primaryKey = 'code';

    public function items(){
        return $this->hasMany(InvoiceItem::class,'invoice_code','code');
    }
}
