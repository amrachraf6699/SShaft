@if ($news->count() > 0)
    <section class="news__top news-home pt-120">
        <div class="container">
            <div class="row align-items-start align-items-md-center flex-column flex-md-row">
                <div class="col-lg-7 col-12">
                    <div class="block-title">
                        <p> آخر الأخبار</p>
                        <h3> جديد جمعية البر بجدة</h3>
                    </div><!-- /.block-title -->
                </div><!-- /.col-lg-7 -->
                <div class="col-lg-5 col-12 d-flex">
                    <div class="my-auto">
                        <p class="block-text pr-10 mb-0">
                            بوابة اخبار البر تقدم اهم اخبار الجمعية على مدار اليوم مع تغطيات مصورة في كافة مجالات النشاط الاجتماعي والخيري
                        </p><!-- /.block-text -->
                    </div><!-- /.my-auto -->
                </div><!-- /.col-lg-5 -->
            </div>
        </div><!-- /.container -->
    </section>

    <section class="news-page pb-120">
        <div class="container">
            <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 3, "spaceBetween": 30,
                            "breakpoints": {
                                "0": {
                                    "slidesPerView": 1,
                                    "spaceBetween": 0
                                },
                                "375": {
                                    "slidesPerView": 1,
                                    "spaceBetween": 30
                                },
                                "575": {
                                    "slidesPerView": 1,
                                    "spaceBetween": 30
                                },
                                "768": {
                                    "slidesPerView": 1,
                                    "spaceBetween": 30
                                },
                                "991": {
                                    "slidesPerView": 2,
                                    "spaceBetween": 30
                                },
                                "1199": {
                                    "slidesPerView": 2,
                                    "spaceBetween": 30
                                },
                                "1200": {
                                    "slidesPerView": 3,
                                    "spaceBetween": 30
                                }
                            }
                            }'>
                <div class="swiper-wrapper">
                    @foreach ($news as $new)
                        <div class="swiper-slide">
                            <div class="wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">
                                <div class="blog-card">
                                    <div class="blog-card__inner">
                                        <div class="blog-card__image">
                                            <img src="{{ $new->image_path }}" alt="{{ $new->title }}">
                                            <div class="blog-card__date">{{ $new->created_at->format('d M') }}</div>
                                        </div><!-- /.blog-card__image -->
                                        <div class="blog-card__content">
                                            <div class="blog-card__meta"></div>
                                            <h3><a href="{{ route('frontend.news-details.show', [$new->blog_section->slug, $new->slug]) }}">{{ $new->title }}</a></h3>
                                            <a href="{{ route('frontend.news-details.show', [$new->blog_section->slug, $new->slug]) }}" class="blog-card__more"><i class="far fa-angle-right"></i>المزيد</a>
                                            <!-- /.blog-card__more -->
                                        </div><!-- /.blog-card__content -->
                                    </div><!-- /.blog-card__inner -->
                                </div><!-- /.blog-card -->
                            </div><!-- /.wow fadeInLeft -->
                        </div><!-- /.swiper-slide -->
                    @endforeach
                </div><!-- /.swiper-wrapper -->
            </div><!-- /.news-3-col -->

        </div><!-- /.container -->
    </section><!-- /.news-page -->
@endif
