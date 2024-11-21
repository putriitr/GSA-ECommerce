<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">{{ __('footer.contact_information') }}</h4>
                    <p class="text-light mb-2"><i class="fas fa-map-marker-alt me-2"></i>{{ $parameter->alamat }}</p>
                    <p class="text-light mb-2"><i class="fas fa-envelope me-2"></i>{{ $parameter->email }}</p>
                    <p class="text-light mb-4"><i class="fas fa-phone me-2"></i>{{ $parameter->nomor_wa }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">{{ __('footer.store') }}</h4>
                    <a class="btn-link" href="{{ route('shop') }}">{{ __('footer.our_products') }}</a>
                    <a class="btn-link" href="{{ route('home') }}">{{ __('footer.favorite') }}</a>
                    <a class="btn-link" href="{{ route('cart.show') }}">{{ __('footer.cart') }}</a>
                    <a class="btn-link" href="{{ route('customer.orders.index') }}">{{ __('footer.purchases') }}</a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">{{ __('footer.get_help') }}</h4>
                    <a class="btn-link" href="{{ route('customer.faq') }}">{{ __('footer.faq_shopping') }}</a>
                </div>
            </div>
            <div class="col-lg-1 col-md-6"></div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item p-3">
                    <h4 class="text-light mb-3">{{ __('footer.consumer_complaints_service') }}</h4>
                    <p class="text-light mb-4">{{ __('footer.consumer_complaints_service_details') }}</p>
                    <div class="d-flex align-items-center">
                        <a class="btn btn-outline-light me-2 btn-md-square rounded-circle" href="mailto:{{ $parameter->email_pengaduan_kementrian }}" title="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a class="btn btn-outline-light btn-md-square rounded-circle me-2" href="{{ $parameter->website_kementerian }}" title="Website">
                            <i class="fas fa-globe"></i>
                        </a>
                        <div class="toggle-button-cover">
                            <div id="button-3" class="button r">
                                <input 
                                    class="checkbox" 
                                    type="checkbox" 
                                    id="languageToggle" 
                                    data-href-id="{{ LaravelLocalization::getLocalizedURL('id', null, [], true) }}" 
                                    data-href-en="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" 
                                    {{ LaravelLocalization::getCurrentLocale() === 'en' ? 'checked' : '' }}
                                >
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <script>
                        // Handle toggle switch change
                        document.getElementById('languageToggle').addEventListener('change', function () {
                            const href = this.checked 
                                ? this.dataset.hrefEn // Switch to English
                                : this.dataset.hrefId; // Switch to Bahasa Indonesia
                            window.location.href = href;
                        });
                    </script>

<style>
.toggle-button-cover {
    display: table-cell;
    position: relative;
    width: 100px;
    height: 50px;
    box-sizing: border-box;
}

.button-cover {
    height: 50px;
    margin: 20px;
    background-color: #fff;
    box-shadow: 0 10px 20px -8px #c5d6d6;
    border-radius: 4px;
}

.button-cover,
.knobs,
.layer {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

.button {
    position: relative;
    top: 50%;
    width: 74px;
    height: 36px;
    margin: -18px auto 0 auto;
    overflow: hidden;
}

.checkbox {
    position: relative;
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 3;
}

.knobs {
    z-index: 2;
}

.layer {
    width: 100%;
    background-color: #ebf7fc;
    transition: 0.3s ease all;
    z-index: 1;
}

.button.r,
.button.r .layer {
    border-radius: 100px;
}

/* ID Style: Red and White */
#button-3 .knobs:before {
    content: "ID";
    position: absolute;
    top: 4px;
    left: 4px;
    width: 26px;
    height: 26px;
    color: #000000;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    line-height: 26px;
    background: linear-gradient(to bottom, #ff0000 50%, #ffffff 50%);
    border-radius: 50%;
    transition: 0.3s ease all, left 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15);
}

/* EN Style: Blue and White */
#button-3 .checkbox:checked + .knobs:before {
    content: "EN";
    left: 42px;
    background: linear-gradient(to bottom, #0000ff 50%, #0000ff 50%);
    color: #ffffff;
}

#button-3 .checkbox:checked ~ .layer {
    background-color: #ebf3ff;
}

</style>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="text-light">
                    <i class="fas fa-copyright text-light me-2"></i>{{ __('footer.footer_copyright') }}
                </span>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top">
    <i class="fa fa-arrow-up text-white"></i>
</a>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/lib/easing/easing.min.js')}}"></script>
<script src="{{ asset('assets/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js')}}"></script>
<script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>

<!-- Template Javascript -->
<script src="{{ asset('assets/js/main.js')}}"></script>
</body>

</html>
