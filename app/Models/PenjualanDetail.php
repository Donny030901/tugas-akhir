<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id_penjualan_detail';
    protected $fillable = [
        'id_penjualan_detail',
        'id_penjualan',
        'id_produk',
        'harga_jual',
        'jumlah',
        'diskon',
        'subtotal',
        'keterangan',
        'created_at',
        'updated_at',
    ];
    protected $guaraded = [];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
    public function member()
    {
        return $this->hasOne(Member::class, 'id_member', 'id_member');
    }
}
