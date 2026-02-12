<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionDocument extends Model
{
    protected $fillable = [
        'submission_id',
        'service_requirement_id',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_at',
        'status',
        'notes',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'verified_at' => 'datetime'
    ];

    public $timestamps = false;

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function requirement()
    {
        return $this->belongsTo(ServiceRequirement::class, 'service_requirement_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}