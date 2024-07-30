<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $guarded = [];

    public function data_seminar()
    {
        return $this->belongsTo(DataSeminar::class);
    }

    public function konfirmasi()
    {
        return $this->hasOne(Konfirmasi::class);
    }
}
