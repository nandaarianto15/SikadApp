<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id', 'user_id', 'service_id', 'perihal', 'tujuan', 'tanggal_surat', 
        'isi_ringkas', 'form_data', // Tambahkan form_data
        'status', 'nomor_surat', 'signed_at', 'signed_by',
        'rejection_reason', 'rejected_at', 'rejected_by'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'signed_at' => 'datetime',
        'rejected_at' => 'datetime',
        'form_data' => 'array', // Tambahkan cast ini
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function documents()
    {
        return $this->hasMany(SubmissionDocument::class);
    }

    public function histories()
    {
        return $this->hasMany(SubmissionHistory::class);
    }

    public function signer()
    {
        return $this->belongsTo(User::class, 'signed_by');
    }
    
    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
    
    public function hasRejectedDocuments()
    {
        return $this->documents()->where('status', 'rejected')->exists();
    }
    
    public function hasPendingDocuments()
    {
        return $this->documents()->where('status', 'pending')->exists();
    }
    
    public function allDocumentsVerified()
    {
        return $this->documents()->whereNotNull('verified_at')->count() === $this->documents()->count();
    }
    
    public function getDocumentStatusSummary()
    {
        $approved = $this->documents()->where('status', 'approved')->count();
        $rejected = $this->documents()->where('status', 'rejected')->count();
        $pending = $this->documents()->where('status', 'pending')->count();
        
        return [
            'approved' => $approved,
            'rejected' => $rejected,
            'pending' => $pending,
            'total' => $approved + $rejected + $pending
        ];
    }
    
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
    
    public function canBeEdited()
    {
        return in_array($this->status, ['revision', 'rejected']);
    }
    
    public function getStatusColorAttribute()
    {
        return [
            'draft' => 'gray',
            'process' => 'blue',
            'revision' => 'yellow',
            'rejected' => 'red',
            'signed' => 'green',
        ][$this->status] ?? 'gray';
    }
    
    public function getStatusLabelAttribute()
    {
        return [
            'draft' => 'Draft',
            'process' => 'Diproses',
            'revision' => 'Revisi',
            'rejected' => 'Ditolak',
            'signed' => 'Ditandatangani',
        ][$this->status] ?? 'Unknown';
    }
}