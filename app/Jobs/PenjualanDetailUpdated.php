<?php

namespace App\Jobs;

use App\Models\PenjualanDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PenjualanDetailUpdated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $penjualan_detail = PenjualanDetail::find($this->data['id_penjualan_detail']);

        $penjualan_detail->update([
            'id_penjualan_detail' => $this->data['id_penjualan_detail'],
            'id_penjualan' => $this->data['id_penjualan'],
            'id_produk' => $this->data['id_produk'],
            'harga_jual' => $this->data['harga_jual'],
            'jumlah' => $this->data['jumlah'],
            'diskon' => $this->data['diskon'],
            'subtotal' => $this->data['subtotal'],
            'created_at' => $this->data['created_at'],
            'updated_at' => $this->data['updated_at'],
        ]);
    }
}
