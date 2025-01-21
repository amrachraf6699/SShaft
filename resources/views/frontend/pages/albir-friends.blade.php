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
                        <a href="{{ route('frontend.list-of-members-of-the-general-assembly.index') }}" class="thm-btn dynamic-radius">عرض القائمة</a>
                        <!-- /.thm-btn dynamic-radius -->
                    </div><!-- /.about-two__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.about-two -->
@endsection
