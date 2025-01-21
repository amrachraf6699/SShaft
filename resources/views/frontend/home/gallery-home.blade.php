@if ($photos->count() > 0)
    <section class="gallery-home-two pt-120 pb-120">
        <div class="container">
            <img src="{{ URL::asset('frontend_files/assets/images/shapes/gallery-dot-1-1.png') }}" alt="" class="gallery-home-two__dots">
            <div class="thm-swiper__slider swiper-container" data-swiper-options='{"spaceBetween": 100, "slidesPerView": 4, "autoplay": { "delay": 5000 }, "breakpoints": {
        "0": {
            "spaceBetween": 0,
            "slidesPerView": 1
        },
        "425": {
            "spaceBetween": 0,
            "slidesPerView": 1
        },
        "575": {
            "spaceBetween": 30,
            "slidesPerView": 2
        },
        "767": {
            "spaceBetween": 30,
            "slidesPerView": 3
        },
        "991": {
            "spaceBetween": 30,
            "slidesPerView": 3
        },
        "1199": {
            "spaceBetween": 30,
            "slidesPerView": 4
        }
    }}'>
                <div class="swiper-wrapper">
                    @foreach ($photos as $photo)
                        <div class="swiper-slide">
                            <div class="gallery-card">
                                <img src="{{ $photo->image_path }}" class="img-fluid" alt="{{ $photo->title }}">
                                <div class="gallery-content">
                                    <a href="{{ $photo->image_path }}" class="img-popup" aria-label="open image"><i class="fal fa-plus"></i></a>
                                </div><!-- /.gallery-content -->
                            </div><!-- /.gallery-card -->
                        </div><!-- /.swiper-slide -->
                    @endforeach
                </div><!-- /.swiper-wrapper -->
            </div><!-- /.swiper-container -->
        </div><!-- /.container -->
    </section>
@endif
