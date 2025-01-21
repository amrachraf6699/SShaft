<div class="main-header__two">
    <div class="main-header__top">
        <div class="container">
            <p>اهلا بكم في {{ $setting->name }}</p>
            <div class="main-header__social">
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
            </div><!-- /.main-header__social -->
        </div><!-- /.container -->
    </div><!-- /.main-header__top -->

    <div class="header-upper">
        <div class="container">
            <div class="logo-box">
                <a href="{{ route('frontend.home') }}" aria-label="logo image"><img src="{{ URL::asset('frontend_files/assets/images/logo.png') }}" width="101" alt=""></a>
                <span class="fa fa-bars mobile-nav__toggler"></span>
            </div><!-- /.logo-box -->
            <div class="header-info">
                <div class="header-info__box">
                    <div class="cart-box">
                        <img src="{{ asset('frontend_files/assets/images/cart.png') }}">
                        <!--<span>0</span>--> <!-- Items Number -->
                    </div>
                    <div class="header-info__box-content">
                        <h3>{{ __('translation.cart') }}</h3>
                        <p><a href="{{ route('frontend.cart.index') }}">{{ __('translation.cart') }}</a></p>
                    </div><!-- /.header-info__box-content -->
                </div><!-- /.header-info__box -->
                <div class="header-info__box">
                    <i class="azino-icon-email1"></i>
                    <div class="header-info__box-content">
                        <h3>البريد الإلكتروني</h3>
                        <p><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></p>
                    </div><!-- /.header-info__box-content -->
                </div><!-- /.header-info__box -->
                <div class="header-info__box">
                    <i class="azino-icon-calling"></i>
                    <div class="header-info__box-content">
                        <h3>رقم الهاتف</h3>
                        <p><a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a></p>
                    </div><!-- /.header-info__box-content -->
                </div><!-- /.header-info__box -->

            </div><!-- /.header-info -->
        </div><!-- /.container -->
    </div><!-- /.header-upper -->

    <nav class="main-menu">
        <div class="container">
            <ul class="main-menu__list dynamic-radius" style="padding-right: 85px;">
                <li class="{{ request()->segment(1) === null ? 'current' : ' ' }}"><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li class="dropdown {{ is_active_nav('about-the-association') }}">
                    <a href="javascript:void(0);">تعرف علينا</a>
                    <ul>
                        <li><a href="{{ route('frontend.about-the-association.brief.view') }}">{{ __('translation.brief') }}</a></li>
                        <li><a href="{{ route('frontend.about-the-association.board-of-director.view') }}">{{ __('translation.board_of_directors') }}</a></li>
                        <li><a href="{{ route('frontend.about-the-association.services-albir.view') }}">{{ __('translation.services_albir') }}</a></li>
                        <li><a href="{{ route('frontend.about-the-association.organizational-chart.view') }}">{{ __('translation.organizational_chart') }}</a></li>
                        <li><a href="{{ route('frontend.about-the-association.statistics.view') }}">{{ __('translation.statistics') }}</a></li>
                        <li><a href="{{ route('frontend.about-the-association.seasonal-projects.view') }}">{{ __('translation.seasonal_projects') }}</a></li>
                        <li><a href="{{ route('frontend.about-the-association.events.view') }}">{{ __('translation.events') }}</a></li>
                        <li><a href="{{ route('frontend.about-the-association.governance-material.view') }}">{{ __('translation.governance_material') }}</a></li>
                        <li><a href="https://albir.sa/videos-sections/%D9%82%D8%A7%D9%84%D9%88%D8%A7-%D8%B9%D9%86%D8%A7">قالوا عنا</a></li>
                    </ul>
                </li>
                <li class="{{ is_active_nav('albir-friends') }}"><a href="{{ route('frontend.albir-friends.view') }}">أصدقاء البر</a></li>

                @php
                    $sections = gitServiceSections()
                @endphp

                <li class="dropdown {{ is_active_nav('services-sections') }}"><a href="javascript:void(0);">{{ __('translation.donate_online') }}</a>
                    <ul>
                        @if ($sections->count() > 0)
                            @foreach ($sections as $section)
                                <li><a href="{{ route('frontend.services-sections', $section->slug) }}">{{ $section->title }}</a></li>
                            @endforeach
                        @else
                            <li><a href="javascript:void(0);">لا توجد أقسام حالياَ</a></li>
                        @endif
                    </ul>
                </li>

                @guest('donor')
                    <li class="{{ is_active_nav('add-a-gift') }}"><a href="#" data-toggle="modal" data-target="#exampleModal">اهداء تبرع</a></li>
                @else
                    <li class="{{ is_active_nav('add-a-gift') }}"><a href="{{ route('frontend.add-a-gift') }}">اهداء تبرع</a></li>
                @endguest

                <li class="dropdown"><a href="javascript:void(0);">المركز الإعلامي</a>
                    <ul>
                        <li class="{{ is_active_nav('news-sections') }}"><a href="{{ route('frontend.news-sections.index') }}">الأخبار</a></li>
                        <li class="{{ is_active_nav('photos-sections') }}"><a href="{{ route('frontend.photos-sections.index') }}">الصور</a></li>
                        <li class="{{ is_active_nav('videos-sections') }}"><a href="{{ route('frontend.videos-sections.index') }}">الفيديو</a></li>
                    </ul>
                </li>
                <li class="{{ is_active_nav('beneficiaries-requests') }}"><a href="{{ route('frontend.beneficiaries-requests.index') }}">طلبات المستفيدين </a></li>
                <li class="{{ is_active_nav('our-branches') }}"><a href="{{ route('frontend.branches.index') }}"> فروعنا</a></li>
                <li class="{{ is_active_nav('contact-us') }}"><a href="{{ route('frontend.contact.index') }}"> اتصل بنا</a></li>
                {{-- <li class="{{ is_active_nav('cart') }}">
                    <a href="{{ route('frontend.cart.index') }}" class="main-shopping-cart">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li> --}}
            </ul><!-- /.main-menu__list -->
            @guest('donor')
                <a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal1" class="thm-btn dynamic-radius">{{ __('web.login') }}</a>
            @else
                <a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal1" class="thm-btn dynamic-radius">مرحباً، {{ auth('donor')->user()->name ?? '' }}</a>
            @endguest
            <!-- /.thm-btn dynamic-radius -->
        </div><!-- /.container -->
    </nav>
    <!-- /.main-menu -->
</div><!-- /.main-header__two -->
