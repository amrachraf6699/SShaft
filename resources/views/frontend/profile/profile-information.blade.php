@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});">
        </div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>بياناتي</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>بياناتي</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <!-- Dashboard -->
    <section class="main-dashboard">
        <div class="grid-container">
            <div class="container">
                <div class="row">
                    @php
                        $member = verifiedGeneralAssemblyMember(auth('donor')->user()->phone);
                    @endphp
                    @include('frontend.profile.sidenav')

                    <div class="col-md-9 col-12">
                        @include('frontend.profile.nav')
                        <div class="edit-profile grid-area">
                            <div class="header">
                                @if ($member)
                                    <h2>عضوية جمعية عمومية</h2>
                                @else
                                    <h2>تعديل المعلومات الشخصية</h2>
                                @endif
                            </div>
                            {{-- <div class="profile-picture">
                                <img src="{{ URL::asset('frontend_files/assets/images/p1.png') }}">
                                <form action="#" method="POST">
                                    <input type="file" accept="image/*">
                                </form>
                            </div> --}}

                            @if ($member)
                                <h2><i class="fa fa-phone-square"></i> {{'رقم الجوال: ' . auth('donor')->user()->phone }}</h2>
                                <h2 style="margin-top: 0;"><i class="fa fa-hashtag"></i> {{'كود عضوية الجمعية العمومية: ' . $member->membership_no }}</h2>
                                <h2 style="margin-top: 0;">
                                    <i class="fa fa-certificate"></i>
                                    <a href="{{ route('frontend.certificate-of-general-assembly-member.show', $member->uuid) }}" target="_blank" rel="noopener noreferrer">شهادة عضوية الجمعية العمومية</a>
                                </h2>
                            @else
                                <h2>{{'رقم الجوال: ' . auth('donor')->user()->phone }}</h2>
                                <form action="{{ route('frontend.profile.update-profile-information', auth('donor')->user()->id) }}" method="POST" class="form-one mb-40">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-control">
                                            <label for="name" class="sr-only">الاسم</label>
                                            <input type="text" name="name" value="{{ old('name', auth('donor')->user()->name) }}" placeholder="اسمك">
                                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div><!-- /.form-control -->
                                        <div class="form-control">
                                            <label for="email" class="sr-only">البريد الإلكتروني</label>
                                            <input type="email" name="email" value="{{ old('email', auth('donor')->user()->email) }}" placeholder="بريدك الإلكتروني">
                                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div><!-- /.form-control -->
                                        <div class="form-control form-control-full">
                                            <button type="submit" class="thm-btn dynamic-radius">تعديل</button>
                                        </div>
                                    </div>

                                    {{-- <div class="form-control">
                                        <label for="phone" class="sr-only">رقم الهاتف</label>
                                        <input type="tel" name="phone" readonly value="{{ old('phone', auth('donor')->user()->phone) }}" placeholder="رقم هاتفك">
                                        @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div> --}}

                                    {{-- <div class="form-group">
                                    <div class="form-control">
                                            <label for="password" class="sr-only">كلمة المرور الجديدة</label>
                                            <input type="password" name="password" autocomplete="new-password" placeholder="كلمة المرور الجديدة">
                                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div><div

                                        <div class="form-control">
                                            <label for="confirm_password" class="sr-only">تأكيد كلمة المرور</label>
                                            <input type="password" name="password_confirmation" autocomplete="new-password" placeholder="تأكيد كلمة المرور">
                                            @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div> --}}
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./Dashboard -->
@endsection
