<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = [
        'id_penjualan',
        'id_member',
        'total_item',
        'total_harga',
        'diskon',
        'bayar',
        'diterima',
        'id_user',
        'created_at',
        'updated_at',
    ];
    protected $guaraded = [];

    public function member()
    {
        return $this->hasOne(Member::class, 'id_member', 'id_member');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}