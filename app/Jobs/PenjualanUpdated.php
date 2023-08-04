<?php

namespace App\Jobs;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PenjualanUpdated implements ShouldQueue
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
        $penjualan = Penjualan::find($this->data['id_penjualan']);

        $penjualan->update([
            'id_penjualan' => $this->data['id_penjualan'],
            'id_member' => $this->data['id_member'],
            'total_item' => $this->data['total_item'],
            'total_harga' => $this->data['total_harga'],
            'diskon' => $this->data['diskon'],
            'bayar' => $this->data['bayar'],
            'diterima' => $this->data['diterima'],
            'id_user' => $this->data['id_user'],
            'created_at' => $this->data['created_at'],
            'updated_at' => $this->data['updated_at'],
        ]);
    }
}
