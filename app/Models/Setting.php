<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'setting';
    protected $primaryKey = 'id_setting';
    protected $fillable = [
        'id_setting',
        'nama_perusahaan',
        'alamat',
        'telepon',
        'tipe_nota',
        'diskon',
        'path_logo',
        'path_kartu_member',
        'created_at',
        'updated_at',
    ];
    protected $guaraded = [];
}
