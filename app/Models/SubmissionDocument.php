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
    ];

    public $timestamps = false;

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
