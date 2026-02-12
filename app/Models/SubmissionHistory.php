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
        'notes'
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function isStatusChange()
    {
        return $this->status_from !== $this->status_to;
    }
    
    public function getStatusColorAttribute()
    {
        return [
            'draft'     => 'gray',
            'process'   => 'blue',
            'revision'  => 'yellow',
            'rejected'  => 'red',
            'signed'    => 'green',
        ][$this->status_to] ?? 'gray';
    }
    
    public function getStatusLabelAttribute()
    {
        return [
            'draft'     => 'Draft',
            'process'   => 'Diproses',
            'revision'  => 'Revisi',
            'rejected'  => 'Ditolak',
            'signed'    => 'Ditandatangani',
        ][$this->status_to] ?? 'Unknown';
    }
}