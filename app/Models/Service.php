<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'form_fields', // Tambahkan ini
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'form_fields' => 'array', // Tambahkan ini
    ];

    public function requirements()
    {
        return $this->hasMany(ServiceRequirement::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}