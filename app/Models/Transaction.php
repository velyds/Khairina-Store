<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'shipping_price',
        'transaction_status',
        'total_price',
        'code',
        'created_at',
        'resi',
        'couriers'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function detail(){
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id','id');
    }
}
