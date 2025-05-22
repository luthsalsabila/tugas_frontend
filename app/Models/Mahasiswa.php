<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa'; // atau nama tabelmu di database

    public $timestamps = false;

    protected $fillable = [
        'nama', 'nim', 'email' // sesuaikan dengan kolom tabel mahasiswa
    ];
}
