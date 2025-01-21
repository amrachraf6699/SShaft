@if ($events->count() > 0)
    <section class="event-home-two pb-120" style="background-image: url({{ URL::asset('frontend_files/assets/images/shapes/event-map-1-2.png') }});">
        <div class="container">
            <div class="row align-items-start align-items-md-center flex-column flex-md-row mb-60">
                <div class="col-lg-7 col-12">
                    <div class="block-title">
                        <p>قائمة أخر الاحداث</p>
                        <h3>تفحص <br> قائمة اخر الاحداث.</h3>
                    </div><!-- /.block-title -->
                </div><!-- /.col-lg-7 -->
                <div class="col-lg-5 col-12 d-flex">
                    <div class="my-auto">
                        <p class="block-text pr-10 mb-0">
                            استكشف الاحداث الاجتماعية والخيرية في المملكة العربية السعودية من خلالنا، حيث نمكنك  من الحصول على كافة المعلومات حول الأنشطة والفعاليات الاجتماعية  مدار العام
                        </p><!-- /.block-text -->
                    </div><!-- /.my-auto -->
                </div><!-- /.col-lg-5 -->
            </div><!-- /.row -->
            <div class="event-grid">
                @foreach ($events as $event)
                        <div class="event-card">
                            <div class="event-card-inner">
                                <div class="event-card-image">
                                    <div class="event-card-image-inner">
                                        <img src="{{ $event->image_path }}" alt="{{ $event->title }}">
                                        <span>{{ $event->date_of_event }}</span>
                                    </div><!-- /.event-card-image-inner -->
                                </div><!-- /.event-card-image -->
                                <div class="event-card-content">
                                    <h3><a href="{{ route('frontend.about-the-association.event.show', $event->slug) }}">{{ $event->title }}</a></h3>
                                    <ul class="event-card-list">
                                        <li>
                                            <i class="far fa-clock"></i>
                                            <strong>الوقت:</strong> {{ $event->time_of_event }}
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <strong>{{ __('translation.location') }}:</strong> {{ $event->location }}
                                        </li>
                                    </ul><!-- /.event-card-list -->
                                    <a href="{{ route('frontend.about-the-association.event.show', $event->slug) }}" class="thm-btn dynamic-radius">المزيد</a>
                                </div><!-- /.event-card-content -->
                            </div><!-- /.event-card-inner -->
                        </div><!-- /.event-card -->
                    @endforeach
            </div><!-- /.event-grid -->
        </div><!-- /.container -->
    </section>
@endif
