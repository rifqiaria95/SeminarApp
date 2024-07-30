<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSeminar extends Model
{
    use HasFactory;

    protected $table = 'data_seminar';

    protected $guarded = [];

    protected $casts = [
        'harga' => 'string',
    ];

    public function pembicara()
    {
        return $this->belongsToMany(Pembicara::class)
                    ->withPivot('data_seminar_id')
                    ->withTimestamps();
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }
}
