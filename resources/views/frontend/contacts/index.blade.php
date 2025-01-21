@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>اتصل بنا</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>اتصل بنا</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    @php
        $setting = setting()
    @endphp

    <section class="contact-page pt-120 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-page__content mb-40">
                        <div class="block-title">
                            <p>اتصل بنا</p>
                            <h3>لا تتردد في كتابة <br> رسالة.</h3>
                        </div><!-- /.block-title -->
                        <p class="block-text mb-30 pr-10">فأنت محط اهتمامنا خذ مساحة لآرءائك أو شكواك و اكتب مايجول في خاطرك وشاركنا اهتماماتك و مقترحاتك في أي مجال</p>
                        <div class="footer-social black-hover">
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
                        </div><!-- /.footer-social -->
                    </div><!-- /.contact-page__content -->
                </div><!-- /.col-lg-5 -->
                <div class="col-lg-7">
                    <form method="POST" action="{{ route('frontend.contact.store') }}" class="contact-page__form form-one mb-40">
                        @csrf
                        <div class="form-group">
                            <div class="form-control">
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('dashboard.name') }}" required>
                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div><!-- /.form-control -->
                            <div class="form-control">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('dashboard.email') }}" required>
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div><!-- /.form-control -->
                            <div class="form-control">
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="{{ __('dashboard.phone') }}" required>
                                @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                            </div><!-- /.form-control -->
                            <div class="form-control">
                                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="{{ __('dashboard.subject') }}" required>
                                @error('subject')<span class="text-danger">{{ $message }}</span>@enderror
                            </div><!-- /.form-control -->
                            <div class="form-control form-control-full">
                                <textarea name="message" placeholder="{{ __('dashboard.message') }}" required>{{ old('message') }}</textarea>
                                @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                            </div><!-- /.form-control -->
                            <div class="form-control form-control-full">
                                <button type="submit" class="thm-btn dynamic-radius">ارسال</button>
                                <!-- /.thm-btn dynamic-radius -->
                            </div><!-- /.form-control -->
                        </div><!-- /.form-group -->
                    </form><!-- /.contact-page__form -->
                </div><!-- /.col-lg-7 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.contact-page -->

    <div class="contact-card-carousel ">
        <div class="container">
            <div class="thm-swiper__slider swiper-container" data-swiper-options='{"spaceBetween": 30, "slidesPerView": 3, "breakpoints": {
                    "0": {
                        "spaceBetween": 0,
                        "slidesPerView": 1
                    },
                    "480": {
                        "spaceBetween": 0,
                        "slidesPerView": 1
                    },
                    "767": {
                        "spaceBetween": 30,
                        "slidesPerView": 2
                    },
                    "1199": {
                        "spaceBetween": 30,
                        "slidesPerView": 3
                    }
                }}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="contact-card d-flex flex-column text-center justify-content-center align-items-center background-secondary"
                            style="background-image: url(assets/images/shapes/contact-card-bg-1-1.png);">
                            <i aria-label="contact icon" class="azino-icon-family"></i>
                            <h3>من نحن</h3>
                            <p>جمعية خيرية تسعى للمساهمة في سد حاجة المعوزين بدعم المانحين</p>
                        </div><!-- /.contact-card -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="contact-card d-flex flex-column text-center justify-content-center align-items-center background-primary"
                            style="background-image: url(assets/images/shapes/contact-card-bg-1-1.png);">
                            <i aria-label="contact icon" class="azino-icon-address"></i>
                            <h3>العنوان</h3>
                            <p>{{ $setting->address }}</p>
                        </div><!-- /.contact-card -->
                    </div><!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="contact-card d-flex flex-column text-center justify-content-center align-items-center background-special"
                            style="background-image: url(assets/images/shapes/contact-card-bg-1-1.png);">
                            <i aria-label="contact icon" class="azino-icon-contact"></i>
                            <h3>تواصل معنا</h3>
                            <p><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a> <br> <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a></p>
                        </div><!-- /.contact-card -->
                    </div><!-- /.swiper-slide -->
                </div><!-- /.swiper-wrapper -->
            </div><!-- /.thm-swiper__slider -->
        </div><!-- /.container -->
    </div><!-- /.contact-card-carousel -->
@endsection
