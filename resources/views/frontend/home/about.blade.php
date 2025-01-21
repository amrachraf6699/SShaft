<section class="about-two pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-12">
                <div class="about-two__image wow fadeInLeft" data-wow-duration="1500ms">
                    <img src="{{ URL::asset('frontend_files/assets/images/k10.png') }}" alt="">
                </div><!-- /.about-two__image -->
            </div><!-- /.col-lg-6 -->

            <div class="col-xl-6 col-12">
                <div class="about-two__content">
                    <div class="block-title">
                        <p> عن جمعية البر</p>
                        <h3>أهلا بكم في جمعية البر بجدة</h3>
                    </div><!-- /.block-title -->
                    {!! $brief->value ? $brief->value : '' !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="about-two__box">
                                <h3><i class="azino-icon-confirmation"></i>كن متبرعا</h3>
                                <p>تعدّ منصة جمعية البر بجدة الحل الأسهل والأمثل لإيصال تبرعاتكم  إلى محتاجيها من خلال عملية تبرع آمنة وشفافة</p>
                            </div><!-- /.about-two__box -->
                            <div class="about-two__box">
                                <h3><i class="azino-icon-confirmation"></i>تبرع سريع</h3>
                                <p>بدون جهد و عناء وعبر قنواتنا الرقمية اسرع حلول التبرع واوثقها</p>
                            </div><!-- /.about-two__box -->
                        </div><!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="about-two__box-two">
                                <i class="azino-icon-support"></i>
                                <h3>بامكانك ان تحدث فرقا في حياة شخص ما</h3>
                            </div><!-- /.about-two__box-two -->
                        </div><!-- /.col-lg-6 -->
                    </div><!-- /.row -->
                    <div class="about-btn thm-btn dynamic-radius">
                        <a href="{{ route('frontend.about-the-association.brief.view') }}">اكتشف المزيد</a>
                        <a href="javascript:void(0);"><i class="fas fa-donate"></i></a>
                        <a href="javascript:void(0);"><i class="fas fa-briefcase-medical"></i></a>
                        <a href="javascript:void(0);"><i class="fas fa-hand-holding-heart"></i></a>
                        <a href="javascript:void(0);"><i class="fas fa-praying-hands"></i></a>
                    </div>
                    <!-- /.thm-btn dynamic-radius -->
                </div><!-- /.about-two__content -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section>
