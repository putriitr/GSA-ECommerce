<body>
    <!-- Pembungkus Tata Letak -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('dashboard') }}" class="app-brand-link d-flex justify-content-center align-items-center" style="height: 100%;">
                        <img src="https://gsacommerce.com/assets/frontend/image/gsa-logo.svg" alt="Logo GSA" class="app-brand-text demo menu-text fw-bolder ms-2" width="180px">
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item">
                        <a href="{{ route('dashboard')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-alt"></i> <!-- Ikon diperbarui menjadi 'bx-home-alt' -->
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Halaman</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-box"></i> <!-- Ikon diperbarui menjadi 'bx-box' untuk Produk -->
                            <div data-i18n="Produk">Produk</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('product.index') }}" class="menu-link">
                                    <div data-i18n="Kelola Produk">Kelola Produk</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('product.categories.index') }}" class="menu-link">
                                    <div data-i18n="Kategori">Kategori</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Transaksi</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-cart"></i> <!-- Ikon keranjang belanja untuk pesanan -->
                            <div data-i18n="Pemesanan">Pemesanan
                                @php
                                    // Jumlah pesanan yang belum dilihat
                                    $unviewedOrdersCount = \App\Models\Order::where('is_viewed', false)->count();
                                @endphp
                                @if ($unviewedOrdersCount > 0)
                                    <span class="badge bg-danger">{{ $unviewedOrdersCount }}</span>
                                @endif
                            </div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.orders.index') }}" class="menu-link">
                                    <div data-i18n="Pemesanan">Pemesanan
                                        @if ($unviewedOrdersCount > 0)
                                        <span class="badge bg-danger">{{ $unviewedOrdersCount }}</span>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-credit-card"></i> <!-- Gunakan ikon kartu kredit -->
                            <div data-i18n="Pembayaran">Pembayaran
                                @php
                                    // Jumlah pembayaran yang belum dilihat
                                    $unviewedPaymentsCount = \App\Models\Payment::where('is_viewed', false)->count();
                                @endphp
                                @if ($unviewedPaymentsCount > 0)
                                    <span class="badge bg-danger">{{ $unviewedPaymentsCount }}</span>
                                @endif
                            </div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.payments.index') }}" class="menu-link">
                                    <div data-i18n="Bukti Pembayaran">Bukti Pembayaran</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Event</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-calendar"></i> 
                            <div data-i18n="Event">Event</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.bigsales.index') }}" class="menu-link">
                                    <div data-i18n="Daftar Event">Big Sale</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Banner</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-image-alt"></i> <!-- Diperbarui menjadi 'bx-image-alt' untuk banner -->
                            <div data-i18n="Banner">Banner</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.banner-home.banners.index') }}" class="menu-link">
                                    <div data-i18n="Home">Home</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.banner-micro.banners.index') }}" class="menu-link">
                                    <div data-i18n="Micro">Micro</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Master Data</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layer"></i> <!-- Diperbarui menjadi 'bx-layer' untuk master data -->
                            <div data-i18n="Master">Master</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('masterdata.shipping.index') }}" class="menu-link">
                                    <div data-i18n="Jasa Angkutan">Jasa Angkutan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('masterdata.parameters.index') }}" class="menu-link">
                                    <div data-i18n="Parameter">Parameter</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">FAQ</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-help-circle"></i> <!-- Ikon bantuan untuk FAQ -->
                            <div data-i18n="FAQ">FAQ</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.faq.index') }}" class="menu-link">
                                    <div data-i18n="FAQ">FAQ</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Manajemen Pengguna</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-user"></i> <!-- Diperbarui menjadi 'bx-user' untuk pengguna -->
                            <div data-i18n="Pengguna">Pengguna</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.users.index') }}" class="menu-link">
                                    <div data-i18n="User">Pengguna</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->
