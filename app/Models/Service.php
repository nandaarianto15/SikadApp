<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
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
