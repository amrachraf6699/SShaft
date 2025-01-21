@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>طلبات المستفيدين</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>طلبات المستفيدين</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="contact-page pt-120 pb-80">
        <div class="container">
            <form action="{{ route('frontend.beneficiaries-requests.store') }}" method="POST" class="contact-page__form form-one request-form mb-40" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="form-control">
                        <span>الاسم:</span>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="الاسم">
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div><!-- /.form-control -->

                    <div class="form-control">
                        <span>رقم الهوية :</span>
                        <input type="number" name="ident_num" value="{{ old('ident_num') }}" placeholder="رقم الهوية">
                        @error('ident_num')<span class="text-danger">{{ $message }}</span>@enderror
                    </div><!-- /.form-control -->

                    <div class="form-control">
                        <span>عدد افراد الاسرة : </span>
                        <input type="number" value="{{ old('num_f_members', 1) }}" min="0" step="1" dir="rtl" name="num_f_members"  placeholder="عدد افراد الاسرة">
                        @error('num_f_members')<span class="text-danger">{{ $message }}</span>@enderror
                    </div><!-- /.form-control -->

                    {{-- <div class="member-btn">
                        <button type="button" class="add">+ أضف فرد جديد</button>
                        <button type="button" class="delete">- حذف فرد</button>
                    </div> --}}
                    {{-- <ul class="list-group">
                        <li>
                            <div class="form-group">
                                <p class="number">الفرد رقم <span>1</span></p>
                                <div class="form-control">
                                    <span>الاسم:</span>
                                    <input type="text" name="member[][memberName]" value="{{ old('memberName') }}" placeholder="الاسم">
                                </div>
                                <div class="form-control">
                                    <span>رقم الهوية :</span>
                                    <input type="number" name="member[][memberIdentNum]" value="{{ old('memberIdentNum') }}" placeholder="رقم الهوية">
                                </div>
                            </div>
                        </li>
                    </ul> --}}

                    <div class="form-control">
                        <span>اختر الحي: </span>
                        <select name="neighborhood">
                            <option selected value="">أختر الحي</option>
                            @foreach ($neighborhoods as $key => $value)
                                <option value="{{ $value }}" {{ ($value == old('neighborhood', $value)) ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('neighborhood')<span class="text-danger">{{ $message }}</span>@enderror
                    </div><!-- /.form-control -->

                    <div class="form-control">
                        <span>رقم الجوال للتواصل  :</span>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال للتواصل">
                        @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                    </div><!-- /.form-control -->
                    <div class="form-control">
                        <span>صورة عن الهوية الوطنية  :</span>
                        <input type="file" name="ident_img" accept=".jpg, .png, image/jpeg, image/png">
                        @error('ident_img')<span class="text-danger">{{ $message }}</span>@enderror
                    </div><!-- /.form-control -->
                    <div class="form-control">
                        <span>إدخل كود التحقق  :</span>
                        <input type="number" name="verification_code" placeholder="إدخل كود التحقق">
                        @error('verification_code')<span class="text-danger">{{ $message }}</span>@enderror
                        <h6 class="verfy-code"><span>رمز التحقق: {{ $verification_code }}</span></h6>
                        <input type="hidden" value="{{ $verification_code }}" name="code">
                    </div><!-- /.form-control -->
                    <div class="form-control form-control-full">
                        <button type="submit" class="thm-btn dynamic-radius">إرسال</button>
                        <!-- /.thm-btn dynamic-radius -->
                    </div><!-- /.form-control -->
                </div><!-- /.form-group -->
            </form><!-- /.contact-page__form -->
        </div><!-- /.container -->
    </section><!-- /.contact-page -->
@endsection
