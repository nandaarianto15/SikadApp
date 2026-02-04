<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRequirement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'service_id',
        'name',
        'description',
        'is_required',
        'sort_order',
    ];
    
    protected $casts = [
        'is_required' => 'boolean',
    ];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}