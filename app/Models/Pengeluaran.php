<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    protected $fillable = [
        'id_pengeluaran',
        'deskripsi',
        'nominal',
        'created_at',
        'updated_at',
    ];
    protected $guaraded = [];
}
