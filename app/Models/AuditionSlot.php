<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditionSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'audition_id',
        'time'
    ];

    protected $casts = ['time' => 'datetime:H:i'];

    public function audition(): BelongsTo
    {
        return $this->belongsTo(Audition::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(AuditionRegistration::class);
    }
}
