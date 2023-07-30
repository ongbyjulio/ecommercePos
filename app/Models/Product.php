<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'description',
        'image'
    ];
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}