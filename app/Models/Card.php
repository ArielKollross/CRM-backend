<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'process_id',
        'process_column_id',
        'customer_id',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function histories()
    {
        return $this->hasMany(CardHistory::class);
    }

    public function processColumn()
    {
        return $this->belongsTo(ProcessColumn::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
