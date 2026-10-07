<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordAttachment extends Model
{
    protected $fillable = [
        'type',
        'path',
        'original_name',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(Record::class);
    }
}
