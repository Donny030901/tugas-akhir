<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;
    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id_pembelian_detail';
    protected $fillable = [
        'id_pembelian_detail',
        'id_pembelian',
        'id_produk',
        'harga_beli',
        'jumlah',
        'subtotal',
        'created_at',
        'updated_at',
    ];
    protected $guaraded = [];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
