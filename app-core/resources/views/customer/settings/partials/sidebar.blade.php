<div class="card shadow border-0 rounded">
    <div class="card-body text-center bg-primary rounded">
        <!-- User Profile Picture -->
        <img src="{{ $user->profile_photo ? asset($user->profile_photo) : asset('assets/default/image/user.png') }}" class="img-fluid rounded-circle mb-3 shadow" alt="User Avatar" style="width: 150px; height: 150px; object-fit: cover;">
        <h5 class="fw-bold mt-2 text-white">{{ $user->full_name }}</h5>
        <hr>

        <!-- Navigation Links -->
        <ul class="nav flex-column text-start bg-primary">
            <li class="nav-item mb-3">
                <a class="nav-link {{ request()->is('settings/account/profile') ? 'active' : '' }}" href="{{ route('user.profile.show') }}" style="color: white; font-weight: bold; background-color: {{ request()->is('settings/account/profile') ? '#ffffff' : 'transparent' }}; color: {{ request()->is('settings/account/profile') ? '#0d6efd' : 'white' }}; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-person"></i> {{ __('settings.your_account') }}
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link {{ request()->is('settings/account/addresses') ? 'active' : '' }}" href="{{ route('user.address.show') }}" style="color: white; font-weight: bold; background-color: {{ request()->is('settings/account/addresses') ? '#ffffff' : 'transparent' }}; color: {{ request()->is('settings/account/addresses') ? '#0d6efd' : 'white' }}; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-geo-alt"></i> {{ __('settings.address') }}
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link {{ request()->is('/customer/orders') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}" style="color: white; font-weight: bold; background-color: {{ request()->is('/customer/orders') ? '#ffffff' : 'transparent' }}; color: {{ request()->is('/customer/orders') ? '#0d6efd' : 'white' }}; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-receipt"></i> {{ __('settings.order_history') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: white; padding: 10px; border-radius: 8px;">
                    <i class="bi bi-box-arrow-right"></i> {{ __('settings.logout') }}
                </a>
            </li>
            
            <!-- Hidden form for logout -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </div>
</div>
