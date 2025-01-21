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

    @if ($photos->count() > 0)
        <section class="gallery-page pt-120 pb-120">
            <div class="container">
                <h3 class="address">الصور</h3>
                <div class="gallery-3-col">
                    @foreach ($photos as $photo)
                        <div>
                            <div class="gallery-card">
                                <img src="{{ $photo->image_path }}" class="img-fluid" alt="{{ $photo->title }}">
                                <div class="gallery-content">
                                    <a href="{{ $photo->image_path }}" class="img-popup" aria-label="open image">
                                        <div><i class="fa fa-eye"></i></div>
                                    </a>
                                </div><!-- /.gallery-content -->
                            </div><!-- /.gallery-card -->
                            <h5><a href="javascript:void(0);">{{ $photo->title }}</a></h5>
                        </div>
                    @endforeach
                </div><!-- /.gallery-3-col -->
                {!! $photos->appends(request()->input())->links() !!}
            </div><!-- /.container -->
        </section><!-- /.gallery-page -->
    @endif
@endsection
