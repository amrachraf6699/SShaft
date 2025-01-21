<section class="main-slider main-slider__two">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @if ($sliders->count() > 0)
                @foreach ($sliders as $slider)
                    <div class="swiper-slide">
                        <div class="image-layer" style="background-image: url({{ $slider->image_path }});">
                            @if ($slider->quick_donation == 'no')
                                <h3>{{ $slider->title }}</h3>
                            @endif

                            @if ($slider->quick_donation == 'yes')
                                <!-- Quick donation -->
                                <form class="quick-dontaion">
                                    <p>تبرع سريعاً</p>
                                    <div class="form-box">
                                        <label>ادخل المبلغ</label>
                                        {{-- <input type="hidden" name="service_id" value="{{ $slider->service_id }}"> --}}
                                        @if ($slider->service->price_value === 'fixed')
                                            <input type="number" name="total_amount" value="{{ $slider->service->basic_service_value }}" readonly min="1" placeholder="0 ر.س" required>
                                        @else
                                            <input type="number" name="total_amount" min="1" placeholder="0 ر.س" required>
                                        @endif
                                        <button type="button" data-id="{{ $slider->service_id }}" data-price_value="{{ $slider->service->price_value }}" data-toggle="modal" data-target="#exampleModal2">ادفع الآن</button>
                                    </div>
                                </form>
                                <!-- ./Quick donation -->
                            @endif
                        </div>
                        <!-- /.image-layer -->
                    </div><!-- /.swiper-slide -->
                @endforeach
            @else
                @php
                    $name = setting()->name
                @endphp

                <div class="swiper-slide">
                    <div class="image-layer" style="background-image: url({{ URL::asset('frontend_files/assets/images/main-slider/slider03.jpg') }});">
                        <h3>{{ $name }}</h3>
                    </div>
                    <!-- /.image-layer -->
                </div><!-- /.swiper-slide -->
            @endif
        </div><!-- /.swiper-wrapper -->

        @if ($sliders->count() > 1)
            <div class="swiper-pagination" id="main-slider-pagination"></div>
        @endif
    </div><!-- /.swiper-container thm-swiper__slider -->
</section>
