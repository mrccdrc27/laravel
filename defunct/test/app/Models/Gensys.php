<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gensys extends Model
{
    // Table settings
    protected $table = 'examples';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // Mass assignable attributes
    protected $fillable = ['name', 'description'];

    // Hidden attributes for serialization
    protected $hidden = ['password'];

    // Casts for attributes
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime:Y-m-d',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    // Query Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Custom Methods
    public function isPublished()
    {
        return $this->published_at !== null;
    }
}
