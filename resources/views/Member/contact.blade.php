@extends('layouts.member.master')

@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url('storage/img/bg.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Contact us</span>
                    </p>
                    <h1 class="mb-0 bread">Contact us</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section contact-section bg-light">
        <div class="container">
            <div class="row d-flex mb-5 contact-info">
                <div class="w-100"></div>
                <div class="col-md-6 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Address :</span> Bizpark Jababeka, Jl. Niaga Industri Selatan 2 Blok QQ2 No.6, Kel.
                            Pasirsari, Kec. Cikarang Selatan, Kab. Bekasi, Prov. Jawa Barat, 17532</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Phone :</span> <a href="tel://6281390069009">+62 813-9006-9009</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Email :</span> <a href="mailto:info@gsacommerce.com">info@gsacommerce.com</a></p>
                    </div>
                </div>
            </div>
            <div class="row block-9">
                <div class="col-md-6 order-md-last d-flex">
                    <form action="#" class="bg-white p-5 contact-form">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="position-relative mx-auto"
                        style="max-width: 800px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <div class="row g-4">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3160.116244913464!2d107.15477407091404!3d-6.311447977376551!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e699b19d041878f%3A0x85e95a0154a93e4c!2sJl.%20Industri%20Sel.%20Blok%20Hh%20No.2%2C%20Pasirsari%2C%20Cikarang%20Sel.%2C%20Kabupaten%20Bekasi%2C%20Jawa%20Barat%2017530!5e1!3m2!1sid!2sid!4v1727256551300!5m2!1sid!2sid"
                                width="500px" height="400px" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    document.getElementById('loadMap').addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah link melakukan aksi default
        document.getElementById('map').innerHTML =
            '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1980.7410879227498!2d107.13115335835156!3d-6.302469100000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69932f9a02a44f%3A0x8db08426c8f47964!2sBizpark%20Jababeka%2C%20Jl.%20Niaga%20Industri%20Selatan%202%20Blok%20QQ2%20No.6%2C%20Pasirsari%2C%20Cikarang%20Sel.%2C%20Bekasi%2C%20Jawa%20Barat%2017532!5e0!3m2!1sid!2sid!4v1695704817955!5m2!1sid!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
    });
</script>
