<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessColumn extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'process_id',
        'name',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
