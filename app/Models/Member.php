<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'member';
    protected $primaryKey = 'id_member';
    protected $fillable = [
        'id_member',
        'kode_member',
        'nama',
        'alamat',
        'telepon',
        'created_at',
        'updated_at',
    ];
    protected $guaraded = [];
}
