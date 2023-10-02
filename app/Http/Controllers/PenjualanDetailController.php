<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('id_produk')->get();
        $kategori = Kategori::orderBy('id_kategori')->get();
        $diskon = Setting::first()->diskon ?? 0;

        //Cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id_penjualan')) {
            return view('penjualan_detail.index', compact('produk', 'diskon', 'id_penjualan', 'kategori'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', $id)->get();

        // return $detail;
        $data = array();
        $total = 0;
        $total_item = 0;
        $hemat = 0;

        foreach ($detail as  $item) {
            $row = array();
            $row['kode_produk'] = '<span class="badge bg-success">' . $item->produk['kode_produk'] . '</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_jual']  = 'Rp. ' . format_uang($item->harga_jual);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id_penjualan_detail . '" data-stok="' . $item->produk->stok . '" value="' . $item->jumlah . '">';
            $row['diskon']      = $item->produk['diskon'] . '%';
            $row['subtotal']    = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`' . route('transaksi.destroy', $item->id_penjualan_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->subtotal;
            $total_item += $item->jumlah;
            $hemat += ($item->subtotal * $item->produk['diskon']) / 100;
        }
        $data[] = [
            'kode_produk' => '
                <div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $total_item . '</div>',
            '<div class="hemat hide">' . $hemat . '</div>',
            'nama_produk' => '',
            'harga_jual'  => '',
            'jumlah'      => '',
            'diskon'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];



        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $produk = Produk::where('id_produk', $request->id_produk)->first();

        if (!$produk) {
            return response()->json('Data gagal di simpan', 400);
        }


        $where = [
            'id_penjualan' => $request->id_penjualan,
            'id_produk' => $produk['id_produk'],
        ];


        $cek_penjualan_detail = PenjualanDetail::where($where)->first();
        if ($cek_penjualan_detail != null) {
            $detail = PenjualanDetail::find($cek_penjualan_detail['id_penjualan_detail']);
            $detail->jumlah = $cek_penjualan_detail['jumlah'] + 1;
            $detail->subtotal = $produk->harga_jual * $detail->jumlah - ($detail->harga_jual * $produk->diskon / 100);
            $detail->diskon = $produk->diskon;
            $detail->update();
        } else {
            $detail = new PenjualanDetail();
            $detail->id_penjualan = $request->id_penjualan;
            $detail->id_produk = $produk->id_produk;
            $detail->harga_jual = $produk->harga_jual;
            $detail->jumlah = 1;
            $detail->diskon = $produk->diskon;
            $detail->subtotal = $produk->harga_jual - ($detail->harga_jual * $produk->diskon / 100);
            $detail->keterangan = 'Online';
            $detail->save();
        }

        return response()->json('Data berhasil di simpan', 200);
    }

    public function update(Request $request, $id)
    {

        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah;
        $detail->diskon = ($detail->subtotal * $detail->produk->diskon) / 100;
        $detail->subtotal = $detail->subtotal - $detail->diskon;
        $detail->diskon = $detail->produk->diskon;
        $detail->update();
    }

    public function destroy($id)
    {

        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }


    public function loadForm($diskon, $total, $diterima)
    {
        $bayar = $total;
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data  = [
            'totalrp'   => format_uang($total),
            'bayar'     => $bayar,
            'bayarrp'   => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali) . 'Rupiah'),
        ];

        return response()->json($data);
    }
}
