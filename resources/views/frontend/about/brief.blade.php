@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>البر في السطور</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>البر في السطور</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="team-page about-albir pt-120 pb-120">
        <div class="container">
            <div class="title">
                <p>{!! $brief->value ? $brief->value : '' !!}</p>
                <h1 class="title">مؤسسو جمعية البر بجدة</h1>
            </div>

            @if ($founders->count() > 0)
                <div class="team-3-col">
                    @foreach ($founders as $index => $founder)
                        <div class="team-card text-center content-bg-{{ $index + 1 }}">
                            <div class="team-card__image">
                                <img src="{{ $founder->image_path }}" alt="{{ $founder->adjective . ' ' . $founder->name }}">
                            </div><!-- /.team-card__image -->
                            {{-- <div class="team-card__social">
                                @if ($founder->twitter_link)
                                    <a href="{{ $founder->twitter_link }}" target="_blank" aria-label="twitter"><i class="fab fa-twitter"></i></a>
                                @else
                                    <a href="javascript:;" aria-label="twitter"><i class="fab fa-twitter"></i></a>
                                @endif

                                @if ($founder->facebook_link)
                                    <a href="{{ $founder->facebook_link }}" target="_blank" aria-label="facebook"><i class="fab fa-facebook-f"></i></a>
                                @else
                                    <a href="javascript:;" aria-label="facebook"><i class="fab fa-facebook-f"></i></a>
                                @endif

                                @if ($founder->instagram_link)
                                    <a href="{{ $founder->instagram_link }}" target="_blank" aria-label="instagram"><i class="fab fa-instagram"></i></a>
                                @else
                                    <a href="javascript:;" aria-label="instagram"><i class="fab fa-instagram"></i></a>
                                @endif

                                @if ($founder->linkedin_link)
                                    <a href="{{ $founder->linkedin_link }}" target="_blank" aria-label="linkedin"><i class="fab fa-linkedin-in"></i></a>
                                @else
                                    <a href="javascript:;" aria-label="linkedin"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                            </div> <!-- /.team-card__social --> --}}
                            <div class="team-card__content">
                                <h5>{{ $founder->adjective }}</h5>
                                <h3>{{ $founder->name }}</h3>
                                <p>{{ $founder->status == 'deceased' ? '((رحمه الله))' : '' }}</p>
                            </div><!-- /.team-card__content -->
                        </div><!-- /.team-card -->
                    @endforeach
                </div><!-- /.team-3-col -->
            @endif
        </div><!-- /.container -->

        <section class="donate-options pt-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="donate-options__content">
                            <div class="block-title">
                                <h3>الرسالة:</h3>
                            </div><!-- /.block-title -->
                            <p>أن تكون الجمعية قدوة وواجهة مشرقة لبلد الحرمين الشريفين في القطاع الخيري وممارسة النشاط الخيري والإنساني في أوسع أطره لرفع الاكتفاء الذاتي للجهات المستفيدة من أيتام وأسر ومرضى لضمان حقهم في المجتمع والبيئة المحيطة .
                            </p>
                            <div class="block-title">
                                <h3>الرؤيا:</h3>
                            </div><!-- /.block-title -->
                            <p>أن نكون رائدين في العمل الخيري المستدام على المستوى المحلي والعالمي .
                            </p>
                            <div class="donate-options__icon-wrap">
                                <div class="donate-options__icon">
                                    <i class="fas fa-heart"></i>
                                </div><!-- /.donate-options__icon -->

                                <div class="donate-options__icon">
                                    <i class="fas fa-cookie-bite"></i>
                                </div><!-- /.donate-options__icon -->

                                <div class="donate-options__icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div><!-- /.donate-options__icon -->

                            </div><!-- /.donate-options__icon-wrap -->
                        </div><!-- /.donate-options__content -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <form action="#" class="donate-options__form wow fadeInUp" data-wow-duration="1500ms">
                            <h3 class="text-center">الأهداف</h3>
                            <ul class="list-unstyled ul-list-one donation-list">
                                <li><i class="far fa-check-circle"></i> التحول من جمعية تعتمد على التبرعات إلى جمعية تحقق الإكتفاء الذاتي وتحقق التنمية المستدامة .</li>
                                <li><i class="far fa-check-circle"></i> تقديم خدمات متنوعة ومتميزة للأيتام والأسر المحتاجة</li>
                                <li><i class="far fa-check-circle"></i>تشجيع العلاقات التكاملية بين القطاع الحكومي والقطاع الخاص والجهات الخيرية لتوجيه مسئوليتها الاجتماعية لأعمال البر الخيرية .</li>
                                <li><i class="far fa-check-circle"></i> نقل الأيتام والأسر المحتاجة من مرحلة الاحتياج إلى مرحلة الاكتفاء .</li>
                                <li><i class="far fa-check-circle"></i> بناء منظومة تواصل مع الجمعيات الخيرية والإنسانية المحلية والعالمية لتبادل الخبرات والمعلومات .</li>
                                <li><i class="far fa-check-circle"></i>  تشجيع التطوع في دعم أنشطة الجمعية المجتمعية .</li>
                            </ul><!-- /.list-unstyled list-style-one -->
                            <!-- /.thm-btn dynamic-radius -->
                        </form><!-- /.donate-options__form -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.donate-options -->
    </section><!-- /.team-page pt-120 -->
@endsection
