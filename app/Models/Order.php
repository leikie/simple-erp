<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'product_id',
        'loan_date',
        'return_date',
        'total_price',
        'qty'
    ];
}
