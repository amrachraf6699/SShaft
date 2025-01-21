<div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <!-- /.mobile-nav__overlay -->
    <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="far fa-times"></i></span>
        <div class="logo-box">
            <a href="{{ route('frontend.home') }}" aria-label="logo image"><img src="{{ URL::asset('frontend_files/assets/images/logo-white.png') }}" width="101" alt="" /></a>
        </div>
        <!-- /.logo-box -->
        <div class="mobile-nav__container"></div>
        <!-- /.mobile-nav__container -->

        <ul class="mobile-nav__contact list-unstyled">
            <li>
                <i class="azino-icon-email"></i>
                <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
            </li>
            <li>
                <i class="azino-icon-telephone"></i>
                <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
            </li>
            <li>
                <i class="fas fa-shopping-cart"></i>
                <a href="{{ route('frontend.cart.index') }}">{{ __('translation.cart') }}</a>
            </li>
            {{-- <li>
                <i class="fas fa-donate"></i>
                <a data-toggle="modal" data-target="#exampleModal1">التبرع السريع</a>
            </li> --}}
        </ul><!-- /.mobile-nav__contact -->
        <div class="mobile-nav__top">
            <div class="mobile-nav__social">
                @if ($setting->twitter)
                    <a href="{{ $setting->twitter }}" aria-label="twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                @endif
                @if ($setting->facebook)
                    <a href="{{ $setting->facebook }}" aria-label="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                @endif
                @if ($setting->youtube)
                    <a href="{{ $setting->youtube }}" aria-label="pinterest" target="_blank"><i class="fab fa-youtube"></i></a>
                @endif
                @if ($setting->instagram)
                    <a href="{{ $setting->instagram }}" aria-label="instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                @endif

                @if ($setting->snapchat)
                    <a href="{{ $setting->snapchat }}" aria-label="snapchat" target="_blank"><i class="fab fa-snapchat"></i></a>
                @endif
                @if ($setting->whatsapp)
                    <a href="https://wa.me/{{ $setting->whatsapp }}" aria-label="whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
                @endif
            </div><!-- /.mobile-nav__social -->
        </div><!-- /.mobile-nav__top -->
    </div>
    <!-- /.mobile-nav__content -->
</div>
