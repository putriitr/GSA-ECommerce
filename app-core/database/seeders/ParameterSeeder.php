<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameter;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parameter::create([
            'logo' => asset('assets/default/image/gsa-logo.svg'),
            'logo_tambahan' => asset('assets/default/image/logo_tambahan.webp'),
            'nomor_wa' => '+62813 9006 9009',
            'email' => 'info@gsacommerce.com',
            'slogan_welcome' => 'Selamat datang di Toko GS acommerce',
            'alamat' => 'Bizpark Jababeka, Jl. Niaga Industri Selatan 2 Blok QQ2 No.6, Kel. Pasirsari, Kec. Cikarang Selatan, Kab. Bekasi, Prov. Jawa Barat, 17532',
            'nama_ecommerce' => 'Toko GSacommerce',
            'email_pengaduan_kementrian' => 'pengaduan.konsumen@kemendag.go.id',
            'website_kementerian' => 'http://simpktn.kemendag.go.id',
        ]);
    }
}
