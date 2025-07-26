<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifiedPayment extends Model
{
    protected $fillable = [
        'order_id',
        'email',
        'verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified_at' => 'datetime',
    ];
}
