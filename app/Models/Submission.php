<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'tracking_id',
        'user_id',
        'service_id',
        'perihal',
        'tujuan',
        'tanggal_surat',
        'isi_ringkas',
        'status',
        'nomor_surat',
        'signed_at',
        'signed_by',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(SubmissionDocument::class);
    }

    public function histories()
    {
        return $this->hasMany(SubmissionHistory::class);
    }
}
