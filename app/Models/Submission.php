<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Submission extends Model
{
    use HasFactory;

    const DOCUMENT_STATUS_PENDING   = 'pending';
    const DOCUMENT_STATUS_APPROVED  = 'approved';
    const DOCUMENT_STATUS_REJECTED  = 'rejected';

    protected $fillable = [
        'tracking_id', 
        'user_id', 
        'service_id', 
        'perihal', 
        'tujuan', 
        'tanggal_surat', 
        'isi_ringkas', 
        'form_data',
        'status', 
        'nomor_surat', 
        'signed_at', 
        'signed_by',
        'rejection_reason', 
        'rejected_at', 
        'rejected_by',
        'document_status', 
        'document_rejection_reason', 
        'document_verified_by', 
        'document_verified_at'
    ];

    protected $casts = [
        'tanggal_surat'         => 'date',
        'signed_at'             => 'datetime',
        'rejected_at'           => 'datetime',
        'document_verified_at'  => 'datetime',
        'form_data'             => 'array',
        'document_status'       => 'string',
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
    
    public function documentVerifier()
    {
        return $this->belongsTo(User::class, 'document_verified_by', 'id');
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
        $approved   = $this->documents()->where('status', 'approved')->count();
        $rejected   = $this->documents()->where('status', 'rejected')->count();
        $pending    = $this->documents()->where('status', 'pending')->count();
        
        return [
            'approved'  => $approved,
            'rejected'  => $rejected,
            'pending'   => $pending,
            'total'     => $approved + $rejected + $pending
        ];
    }
    
    public function isDocumentVerified()
    {
        return $this->document_status === self::DOCUMENT_STATUS_APPROVED;
    }
    
    public function isDocumentRejected()
    {
        return $this->document_status === self::DOCUMENT_STATUS_REJECTED;
    }
    
    public function isDocumentPending()
    {
        return $this->document_status === self::DOCUMENT_STATUS_PENDING;
    }
    
    public function allDocumentsApproved()
    {
        if (!$this->isDocumentVerified()) {
            return false;
        }

        $hasUnapproved = $this->documents()->where('status', '!=', self::DOCUMENT_STATUS_APPROVED)->exists();

        return !$hasUnapproved;
    }
    
    public function hasAnyRejectedDocument()
    {
        $documentPreviewRejected    = $this->isDocumentRejected();
        $hasRejectedRequirement     = $this->documents()->where('status', 'rejected')->exists();
        
        return $documentPreviewRejected || $hasRejectedRequirement;
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
            'draft'     => 'gray',
            'process'   => 'blue',
            'revision'  => 'yellow',
            'rejected'  => 'red',
            'signed'    => 'green',
        ][$this->status] ?? 'gray';
    }
    
    public function getStatusLabelAttribute()
    {
        return [
            'draft'     => 'Draft',
            'process'   => 'Diproses',
            'revision'  => 'Revisi',
            'rejected'  => 'Ditolak',
            'signed'    => 'Ditandatangani',
        ][$this->status] ?? 'Unknown';
    }

    public function getDocumentStatusLabelAttribute()
    {
        return [
            self::DOCUMENT_STATUS_PENDING   => 'Menunggu Verifikasi',
            self::DOCUMENT_STATUS_APPROVED  => 'Disetujui',
            self::DOCUMENT_STATUS_REJECTED  => 'Ditolak',
        ][$this->document_status] ?? 'Tidak Diketahui';
    }
}