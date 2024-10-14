<div class="card shadow border-0 rounded">
    <div class="card-body text-center bg-primary rounded">
        <!-- User Profile Picture -->
        <img src="{{ asset($user->profile_photo ?? 'https://static.thenounproject.com/png/5100711-200.png') }}" class="img-fluid rounded-circle mb-3 shadow" alt="User Avatar" style="width: 150px; height: 150px; object-fit: cover;">
        <h5 class="fw-bold mt-2 text-white">{{ $user->full_name }}</h5>
        <hr>
        <!-- Navigation Links -->
        <ul class="nav flex-column text-start bg-primary">
            <li class="nav-item mb-3">
                <a class="nav-link {{ request()->is('settings/account/profile') ? 'active' : '' }}" href="{{ route('user.profile.show') }}" style="color: white; font-weight: bold; background-color: {{ request()->is('settings/account/profile') ? '#ffffff' : 'transparent' }}; color: {{ request()->is('settings/account/profile') ? '#0d6efd' : 'white' }}; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-person"></i> Akunmu
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link {{ request()->is('settings/account/addresses') ? 'active' : '' }}" href="{{ route('user.address.show') }}" style="color: white; font-weight: bold; background-color: {{ request()->is('settings/account/addresses') ? '#ffffff' : 'transparent' }}; color: {{ request()->is('settings/account/addresses') ? '#0d6efd' : 'white' }}; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-geo-alt"></i> Alamat
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link" style="color: white; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-receipt"></i> Riwayat Pesanan
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link" style="color: white; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-envelope"></i> Keluhan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: white; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </a>
            </li>
            
            <!-- Hidden form for logout -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </div>
</div>
