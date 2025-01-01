<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function cardHistories()
    {
        return $this->hasMany(CardHistory::class);
    }
}
