<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Audition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'start',
        'max_per_slot'
    ];

    protected $casts = ['start' => 'datetime:H:i', 'date' => 'date'];

    public function slots(): HasMany
    {
        return $this->hasMany(AuditionSlot::class);
    }


}
