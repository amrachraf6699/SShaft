@extends('frontend.layouts.app')

@section('content')
    <!-- change add join modal-->
    <div class="modal fade" id="joinModal" tabindex="-1" aria-labelledby="joinModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اختر نوع العضوية </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($packages->count() > 0)
                        @foreach ($packages as $package)
                            <a href="{{ route('frontend.general-assembly-members.form', $package->slug) }}" class="thm-btn dynamic-radius btn-block text-center">{{ $package->title }}</a>
                        @endforeach
                    @else
                        <a href="javascript:void(0);" class="thm-btn dynamic-radius disabled">لا يوجد عضويات</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- ./ change join moadal -->

    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>أصدقاء البر</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>أصدقاء البر</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="about-two pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="about-two__image wow fadeInLeft" data-wow-duration="1500ms">
                        @if ($general_assembly_members->img)
                            <img src="{{ $general_assembly_members->image_path }}" alt="اعضاء الجمعية العمومية">
                        @endif
                    </div><!-- /.about-two__image -->
                </div><!-- /.col-lg-6 -->
                <div class="col-xl-6">
                    <div class="about-two__content">
                        <div class="block-title">
                            <h3>اعضاء الجمعية العمومية</h3>
                        </div><!-- /.block-title -->
                        @if ($packages->count() > 0)
                            <p class="pr-10">قيمة الاشتراك :</p>
                            <ul class="list-unstyled">قيمة العضويات
                                @foreach ($packages as $package)
                                    <li><i class="fas fa-award"></i>{{ $package->title }} ( {{ $package->price }} ) {{ __('translation.annually') }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <ul id="accordion" class=" wow fadeInUp list-unstyled" data-wow-duration="1500ms">
                            <li class="charity">
                                <h2 class="para-title">
                                    <span class="collapsed" role="button" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <i class="far fa-plus"></i>
                                        كيفية الانضمام
                                    </span>
                                </h2>
                                <div id="collapseTwo" class="collapse" role="button" aria-labelledby="collapseTwo" data-parent="#accordion">
                                    {!! $general_assembly_members->how_to_join ? $general_assembly_members->how_to_join : '' !!}
                                </div>
                            </li>
                            <li class="charity">
                                <h2 class="para-title active">
                                    <span class="collapsed" role="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        <i class="far fa-minus"></i>
                                        شروط الانضمام
                                    </span>
                                </h2>
                                <div id="collapseOne" class="collapse show" aria-labelledby="collapseOne" data-parent="#accordion">
                                    {!! $general_assembly_members->joining_terms ? $general_assembly_members->joining_terms : '' !!}
                                </div>
                            </li>
                            <li class="charity">
                                <h2 class="para-title">
                                    <span class="collapsed" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="false" role="button" aria-controls="collapseThree">
                                        <i class="far fa-plus"></i>
                                        مميزات العضوية
                                    </span>
                                </h2>
                                <div id="collapseThree" class="collapse" aria-labelledby="collapseThree" data-parent="#accordion">
                                    {!! $general_assembly_members->membership_benefits ? $general_assembly_members->membership_benefits : '' !!}
                                </div>

                            </li>
                        </ul>


                        <!-- change -->
                        <a href="#" data-toggle="modal" data-target="#joinModal" class="thm-btn dynamic-radius">انضم إلى القائمة</a>
                        <!-- ./change -->
                        <a href="about.html" class="thm-btn dynamic-radius">عرض القائمة</a>
                        <!-- /.thm-btn dynamic-radius -->
                    </div><!-- /.about-two__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.about-two -->

    <section class="about-two pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="about-two__image wow fadeInLeft" data-wow-duration="1500ms">
                        @if ($donor_membership->img)
                            <img src="{{ $donor_membership->image_path }}" alt="عضوية المتبرعين">
                        @endif
                    </div><!-- /.about-two__image -->
                </div><!-- /.col-lg-6 -->
                <div class="col-xl-6">
                    <div class="about-two__content">
                        <div class="block-title">
                            <h3>عضوية المتبرعين</h3>
                        </div><!-- /.block-title -->

                        <ul id="accordion" class=" wow fadeInUp list-unstyled" data-wow-duration="1500ms">
                            <li class="charity">
                                <h2 class="para-title">
                                    <span class="collapsed" role="button" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <i class="far fa-plus"></i>
                                        كيفية الانضمام
                                    </span>
                                </h2>
                                <div id="collapseTwo" class="collapse" role="button" aria-labelledby="collapseTwo" data-parent="#accordion">
                                    {!! $donor_membership->how_to_join ? $donor_membership->how_to_join : '' !!}
                                </div>
                            </li>
                            <li class="charity">
                                <h2 class="para-title active">
                                    <span class="collapsed" role="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        <i class="far fa-minus"></i>
                                        شروط الانضمام
                                    </span>
                                </h2>
                                <div id="collapseOne" class="collapse show" aria-labelledby="collapseOne" data-parent="#accordion">
                                    {!! $donor_membership->joining_terms ? $donor_membership->joining_terms : '' !!}
                                </div>
                            </li>
                            <li class="charity">
                                <h2 class="para-title">
                                    <span class="collapsed" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="false" role="button" aria-controls="collapseThree">
                                        <i class="far fa-plus"></i>
                                        مميزات العضوية
                                    </span>
                                </h2>
                                <div id="collapseThree" class="collapse" aria-labelledby="collapseThree" data-parent="#accordion">
                                    {!! $donor_membership->membership_benefits ? $donor_membership->membership_benefits : '' !!}
                                </div>

                            </li>
                        </ul>

                        <a href="{{ route('frontend.albir-friends.registration-form.view', 'donor_membership') }}" class="thm-btn dynamic-radius">انضم الى عضوية المتبرعين</a>

                        <!-- /.thm-btn dynamic-radius -->
                    </div><!-- /.about-two__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.about-two -->

    <section class="about-two pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="about-two__image wow fadeInLeft" data-wow-duration="1500ms">
                        @if ($volunteer_membership->img)
                            <img src="{{ $volunteer_membership->image_path }}" alt="عضوية المتطوعين">
                        @endif
                    </div><!-- /.about-two__image -->
                </div><!-- /.col-lg-6 -->
                <div class="col-xl-6">
                    <div class="about-two__content">
                        <div class="block-title">

                            <h3>عضوية المتطوعين</h3>
                        </div><!-- /.block-title -->

                        <ul id="accordion" class=" wow fadeInUp list-unstyled" data-wow-duration="1500ms">
                            <li class="charity">
                                <h2 class="para-title">
                                    <span class="collapsed" role="button" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <i class="far fa-plus"></i>
                                        كيفية الانضمام
                                    </span>
                                </h2>
                                <div id="collapseTwo" class="collapse" role="button" aria-labelledby="collapseTwo" data-parent="#accordion">
                                    {!! $volunteer_membership->how_to_join ? $volunteer_membership->how_to_join : '' !!}
                                </div>
                            </li>
                            <li class="charity">
                                <h2 class="para-title active">
                                    <span class="collapsed" role="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        <i class="far fa-minus"></i>
                                        شروط الانضمام
                                    </span>
                                </h2>
                                <div id="collapseOne" class="collapse show" aria-labelledby="collapseOne" data-parent="#accordion">
                                    {!! $volunteer_membership->joining_terms ? $volunteer_membership->joining_terms : '' !!}
                                </div>
                            </li>
                            <li class="charity">
                                <h2 class="para-title">
                                    <span class="collapsed" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="false" role="button" aria-controls="collapseThree">
                                        <i class="far fa-plus"></i>
                                        مميزات العضوية
                                    </span>
                                </h2>
                                <div id="collapseThree" class="collapse" aria-labelledby="collapseThree" data-parent="#accordion">
                                    {!! $volunteer_membership->membership_benefits ? $volunteer_membership->membership_benefits : '' !!}
                                </div>

                            </li>
                        </ul>
                        <a href="#" class="thm-btn dynamic-radius">انضم الى عضوية المتطوعين</a>
                        <a href="#" class="thm-btn dynamic-radius">عرض قائمة الاعضاء</a>

                        <!-- /.thm-btn dynamic-radius -->
                    </div><!-- /.about-two__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.about-two -->

    <section class="about-two pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="about-two__image wow fadeInLeft" data-wow-duration="1500ms">
                        @if ($beneficiaries_membership->img)
                            <img src="{{ $beneficiaries_membership->image_path }}" alt="عضوية المستحقين">
                        @endif
                    </div><!-- /.about-two__image -->
                </div><!-- /.col-lg-6 -->
                <div class="col-xl-6">
                    <div class="about-two__content">
                        <div class="block-title">

                            <h3>عضوية المستحقين</h3>
                        </div><!-- /.block-title -->

                        <ul id="accordion" class=" wow fadeInUp list-unstyled" data-wow-duration="1500ms">
                            <li class="charity">
                                <h2 class="para-title">
                                    <span class="collapsed" role="button" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <i class="far fa-plus"></i>
                                        كيفية الانضمام
                                    </span>
                                </h2>
                                <div id="collapseTwo" class="collapse" role="button" aria-labelledby="collapseTwo" data-parent="#accordion">
                                    {!! $beneficiaries_membership->how_to_join ? $beneficiaries_membership->how_to_join : '' !!}
                                </div>
                            </li>
                            <li class="charity">
                                <h2 class="para-title active">
                                    <span class="collapsed" role="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        <i class="far fa-minus"></i>
                                        شروط الانضمام
                                    </span>
                                </h2>
                                <div id="collapseOne" class="collapse show" aria-labelledby="collapseOne" data-parent="#accordion">
                                    {!! $beneficiaries_membership->joining_terms ? $beneficiaries_membership->joining_terms : '' !!}
                                </div>
                            </li>
                            <li class="charity">
                                <h2 class="para-title">
                                    <span class="collapsed" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="false" role="button" aria-controls="collapseThree">
                                        <i class="far fa-plus"></i>
                                        مميزات العضوية
                                    </span>
                                </h2>
                                <div id="collapseThree" class="collapse" aria-labelledby="collapseThree" data-parent="#accordion">
                                    {!! $beneficiaries_membership->membership_benefits ? $beneficiaries_membership->membership_benefits : '' !!}
                                </div>

                            </li>
                        </ul>
                        <a href="{{ route('frontend.albir-friends.registration-form.view', 'beneficiaries_membership') }}" class="thm-btn dynamic-radius">انضم الى عضوية المستحقين</a>
                        {{-- <a href="#" class="thm-btn dynamic-radius">عرض قائمة الاعضاء</a> --}}

                        <!-- /.thm-btn dynamic-radius -->
                    </div><!-- /.about-two__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.about-two -->
@endsection
