<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'SPOS',
            'Alamat' => 'Jl. Raya Rambay No 25',
            'telepon' => '089516823902',
            'tipe_nota' => 1, //Kecil
            'diskon' => 5,
            'path_logo' => '/images/logo.png',
            'path_kartu_member' => '/images/member.png',

        ]);
    }
}
