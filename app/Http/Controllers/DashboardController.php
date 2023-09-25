<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        setlocale(LC_TIME, 'id_ID');
        $today = Carbon::today();
        $penjualan_hariIni = Penjualan::whereDate('created_at', $today)->count();
        $profit = PenjualanDetail::with('produk')
            ->whereDate('created_at', $today)->get();
        // dd($profit);

        $total_profit = 0;
        foreach ($profit as $penjualan_ku) {
            $jual = ($penjualan_ku->harga_jual - $penjualan_ku->produk['harga_beli']) * $penjualan_ku->jumlah - ($penjualan_ku->harga_jual * $penjualan_ku->diskon / 100);
            $total_profit += $jual; // Hitung keuntungan per transaksi
        }
        $total_profit = "Rp. " . format_uang($total_profit);
        $pelanggan = Penjualan::whereDate('created_at', $today)->distinct('id_penjualan')->count();
        $total_penjualan = Penjualan::whereDate('created_at', $today)->sum('total_harga');
        $total_penjualan = "Rp. " . format_uang($total_penjualan);


        $tahunIni = Carbon::now()->year;
        $bulanIni = Carbon::now()->month;

        $tanggalMulai = Carbon::create($tahunIni, $bulanIni, 1, 0, 0, 0);
        $tanggalAkhir = Carbon::now();

        // Menghitung total pengeluaran bulan ini
        $totalPengeluaran = Pengeluaran::whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])->sum('nominal');

        // Menghitung total pembelian bulan ini
        $totalPembelian = Pembelian::whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])->sum('total_harga');

        // Menghitung total penjualan bulan ini
        $totalPenjualan = Penjualan::whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])->sum('total_harga');

        // Menghitung total pendapatan bulan ini
        $totalPendapatan = $totalPenjualan - ($totalPembelian + $totalPengeluaran);
        // Format tanggal awal bulan sampai akhir bulan
        $tanggalAwalBulan = $tanggalMulai->formatLocalized('%d %B %Y');
        $tanggalAkhirBulan = $tanggalAkhir->formatLocalized('%d %B %Y');

        $produkTerlaris = PenjualanDetail::with('produk')->select('id_produk', DB::raw('SUM(jumlah) as total_terjual'))
            ->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])
            ->groupBy('id_produk')
            ->havingRaw('SUM(jumlah) >= 30')
            ->orderByDesc('total_terjual')
            ->limit(3)
            ->get();

        return view('home', compact('penjualan_hariIni', 'profit', 'pelanggan', 'total_profit', 'total_penjualan', 'totalPendapatan', 'tanggalAwalBulan', 'tanggalAkhirBulan', 'produkTerlaris'));
    }
}
