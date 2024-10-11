@extends('layouts.customer.master')

@section('content')
    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5"
        style="position: relative; overflow: hidden; background: url('{{ asset('storage/img/contact.jpg') }}') no-repeat center center; background-size: cover;">
        <div style="background: rgba(0, 0, 0, 0.5); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;">
        </div>
        <h1 class="text-center text-white display-6" style="position: relative; z-index: 2;">Kontak</h1>
        <ol class="breadcrumb justify-content-center mb-0" style="position: relative; z-index: 2;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
            <li class="breadcrumb-item active text-white">Kontak</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">Hubungi Kami</h1>
                            <p class="mb-4">Kami ingin mendengar dari Anda! Jika Anda memiliki pertanyaan atau memerlukan
                                bantuan, jangan ragu untuk menghubungi kami. Lengkapi formulir di bawah ini, dan tim kami
                                akan berusaha memberikan jawaban secepatnya.</p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="h-100 rounded">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.250022598491!2d107.33012501479207!3d-6.193152895507679!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e699f4b7e9b1d97%3A0x22447d33e0321d6d!2sBizpark%20Jababeka%2C%20Jl.%20Niaga%20Industri%20Selatan%202%20Blok%20QQ2%20No.6%2C%20Kel.%20Pasirsari%2C%20Kec.%20Cikarang%20Selatan%2C%20Kab.%20Bekasi%2C%20Prov.%20Jawa%20Barat%2C%2017532!5e0!3m2!1sen!2sid!4v1697025241443!5m2!1sen!2sid"
                                width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>

                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form action="" class="">
                            <input type="text" class="w-100 form-control border-0 py-3 mb-4" placeholder="Nama Lengkap">
                            <input type="email" class="w-100 form-control border-0 py-3 mb-4" placeholder="Email Anda">
                            <input type="phone" class="w-100 form-control border-0 py-3 mb-4" placeholder="Nomor Telepon">
                            <textarea class="w-100 form-control border-0 mb-4" rows="5" cols="10" placeholder="Pesan Anda"></textarea>
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary "
                                type="submit">Kirim Pesan</button>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Alamat</h4>
                                <p class="mb-2">Bizpark Jababeka, Jl. Niaga Industri Selatan 2 Blok QQ2 No.6, Kel. Pasirsari, Kec. Cikarang Selatan, Kab. Bekasi, Prov. Jawa Barat, 17532</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Email</h4>
                                <p class="mb-2">info@gsacommerce.com</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded bg-white">
                            <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Telepon</h4>
                                <p class="mb-2">+62 813-9006-9009</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
