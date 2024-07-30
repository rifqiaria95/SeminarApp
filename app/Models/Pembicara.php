<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembicara extends Model
{
    use HasFactory;

    protected $table = 'pembicara';

    protected $guarded = [];

    public function data_seminar()
    {
        return $this->belongsToMany(DataSeminar::class)
                    ->withPivot('pembicara_id')
                    ->withTimestamps();
    }
}
