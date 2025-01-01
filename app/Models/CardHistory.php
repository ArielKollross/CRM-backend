<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardHistory extends Model
{
    use HasFactory;

    protected $table = 'card_histories';

    protected $fillable = [
        'card_id',
        'process_column_id',
        'created_at',
        'updated_at',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function process_column()
    {
        return $this->belongsTo(ProcessColumn::class);
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
