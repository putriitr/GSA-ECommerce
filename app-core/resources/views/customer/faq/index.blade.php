@extends('layouts.customer.master')

@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5"
    style="position: relative; overflow: hidden; background: url('{{ asset('storage/img/faq-header-bg.jpg') }}') no-repeat center center; background-size: cover;">
    <div style="background: rgba(0, 0, 0, 0.096); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;"></div>
    <h1 class="text-center text-dark display-4 fw-bold" style="position: relative; z-index: 2;">Frequently Asked Questions</h1>
    <ol class="breadcrumb justify-content-center mb-0" style="position: relative; z-index: 2;">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Beranda</a></li>
        <li class="breadcrumb-item active text-primary">FAQ</li>
    </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- FAQ Section -->
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Informasi FAQ</h2>
        @if($faqs->count() > 0)
            {!! $faqs->first()->keterangan !!} <!-- Assuming you want to show the first FAQ -->
        @else
            <p class="text-muted">Tidak ada informasi FAQ tersedia.</p>
        @endif
    </div>

@endsection
