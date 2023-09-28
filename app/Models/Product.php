<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'expired_date',
        'unit_price',
        'size',
        'category',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
