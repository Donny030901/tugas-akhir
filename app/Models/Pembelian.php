<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $fillable = [
        'id_pembelian',
        'id_supplier',
        'total_item',
        'total_harga',
        'diskon',
        'bayar',
        'created_at',
        'updated_at',
    ];
    protected $guaraded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }
}
