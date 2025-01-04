<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model
{
    /** @use HasFactory<\Database\Factories\ProcessFactory> */
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function columns()
    {
        return $this->hasMany(ProcessColumn::class);
    }
}
