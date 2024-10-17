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
                    </div>
                    <div class="dropdown mt-3">
                        <button class="btn btn-outline-light dropdown-toggle w-100" type="button" id="languageToggle" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ LaravelLocalization::getCurrentLocale() == 'en' ? 'English' : 'Bahasa Indonesia' }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="languageToggle" style="width: 100%; box-sizing: border-box;">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
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
