<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Record extends Model
{
    protected $fillable = [
        'farmerName',
        'address',
        'province',
        'municipality',
        'barangay',
        'line',
        'program',
        'causeOfDamage',
        'modeOfPayment',
        'accounts',
        'facebook_page_url',
        'notice_image_path',
        'notice_pdf_path',
        'date_occurrence',
        'date_received',
        'remarks',
        'control_number',
        'source',
        'transmittal_number',
        'admin_transmittal_number',
        'admin_transmittal_assigned_at',
        'encoderName',
        'encoder_id',
        'approved',
        'approved_at',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'approved_at' => 'datetime',
        'date_received' => 'date',
    ];

    public function setAttribute($key, $value)
    {
        if (is_string($value) && in_array($key, [
            'farmerName',
            'address',
            'province',
            'municipality',
            'barangay',
            'line',
            'program',
            'causeOfDamage',
            'modeOfPayment',
            'accounts',
            'remarks',
            'control_number',
            'transmittal_number',
            'admin_transmittal_number',
            'encoderName',
        ], true)) {
            $value = trim($value);
            if ($value !== '') {
                $value = mb_strtoupper($value, 'UTF-8');
            }
        }

        parent::setAttribute($key, $value);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(RecordAttachment::class)->orderBy('id');
    }
}
