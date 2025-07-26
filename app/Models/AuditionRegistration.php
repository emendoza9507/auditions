<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditionRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'age', 'parent_name', 'phone',
        'instrument', 'email', 'audition_id',
        'audition_slot_id', 'agreed_terms', 'payment_order_id', 'payment_status'
    ];

    protected $casts = [
        'agreed_terms' => 'boolean'
    ];

    public function audition(): BelongsTo
    {
        return $this->belongsTo(Audition::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(AuditionSlot::class, 'audition_slot_id', 'id');
    }
}
