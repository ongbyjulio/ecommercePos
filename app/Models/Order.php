<?php

namespace App\Models;


use App\Models\Messagge;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_paid',
        'comment',
        'payment_receipt',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function message()
    {
        return $this->hasMany(Messagge::class);
    }

}