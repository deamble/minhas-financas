<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'platform',
        'api_key',
        'api_secret',
        'status',
        'user_id',
        'settings',
    ];

    protected $casts = [
        'status' => 'boolean',
        'settings' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
} 