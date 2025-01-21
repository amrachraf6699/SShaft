@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>الصور</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>الصور</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    @if ($sections->count() > 0)
        <section class="gallery-page pt-120 pb-120">
            <div class="container">
                <h3 class="address">أقسام الصور</h3>
                <div class="gallery-3-col">
                    @foreach ($sections as $section)
                        <div>
                            <div class="gallery-card">
                                <img src="{{ $section->image_path }}" class="img-fluid" alt="{{ $section->title }}">
                                <div class="gallery-content">
                                    <a href="{{ $section->image_path }}" class="img-popup" aria-label="open image">
                                        <div><i class="fa fa-list-ul"></i><strong> {{ $section->photos_count }}</strong></div>
                                        {{-- <div><i class="fa fa-eye"></i><strong>732</strong></div> --}}
                                    </a>
                                </div><!-- /.gallery-content -->
                            </div><!-- /.gallery-card -->
                            <h5><a href="{{ route('frontend.photos.index', $section->slug) }}">{{ $section->title }}</a></h5>
                        </div>
                    @endforeach
                </div><!-- /.gallery-3-col -->

                <!-- pagination -->
                {!! $sections->appends(request()->input())->links() !!}
                <!-- ./Pagination -->
            </div><!-- /.container -->
        </section><!-- /.gallery-page -->
    @endif
@endsection
