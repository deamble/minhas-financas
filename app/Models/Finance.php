<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'transaction_type',
        'value_transaction',
        'description',
        'short_description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function scopeEntries($query)
    {
        return $query->where('transaction_type', 'entrada');
    }

    public function scopeExpenses($query)
    {
        return $query->where('transaction_type', 'saida');
    }


}
