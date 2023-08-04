<?php

namespace App\Http\Controllers;


use App\Models\Member;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $produk = Produk::count();
        $supplier = Supplier::count();
        $member = Member::count();
        $penjualan = Penjualan::count();

        return view('home', compact('penjualan', 'produk', 'supplier', 'member'));
    }
}
