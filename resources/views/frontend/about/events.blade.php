@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ __('translation.events') }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ __('translation.events') }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="event-page pt-120 pb-120">
        <div class="container">
            @if ($events->count() > 0)
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
            @endif

            {!! $events->appends(request()->input())->links() !!}
        </div><!-- /.container -->
    </section><!-- /.event-page -->
@endsection
