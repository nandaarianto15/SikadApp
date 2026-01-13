<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionHistory extends Model
{
    protected $fillable = [
        'submission_id',
        'user_id',
        'status_from',
        'status_to',
        'notes',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
