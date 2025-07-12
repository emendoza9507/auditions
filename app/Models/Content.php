<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Content extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $fillable = [
        'audition_id', 'title', 'slug', 'content', 'order',
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public function audition(): BelongsTo
    {
        return $this->belongsTo(Audition::class);
    }
}
