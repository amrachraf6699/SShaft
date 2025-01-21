<nav>
    <a class="{{ is_active('profile') }}" href="{{ route('frontend.profile.show-profile-information', auth('donor')->user()->username) }}">
        <i class="far fa-user"></i>
        <span>
            البيانات الشخصية
        </span>
    </a>

    <a class="{{ is_active('donations') }}" href="{{ route('frontend.donations.index') }}">
        <i class="far fa-clipboard"></i>
        <span>
            سجل التبرعات
        </span>
    </a>

    <a class="{{ is_active('cart') }}" href="{{ route('frontend.cart.index') }}">
        <i class="fas fa-shopping-basket"></i>
        <span>
            سلة التبرع
        </span>
    </a>

    <a class="{{ is_active('my-bills') }}" href="{{ route('frontend.my-bills.index') }}">
        <i class="fas fa-money-bill"></i>
        <span>
            {{ __('translation.my_bills') }}
        </span>
    </a>

    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
        <i class="fas fa-power-off"></i><span>{{ __('web.logout') }}</span>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</nav>
