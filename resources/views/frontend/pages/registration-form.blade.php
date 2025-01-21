@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>انضم إلينا</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><a href="{{ route('frontend.albir-friends.view') }}">أصدقاء البر</a></li>
                <li>-</li>
                <li><span>انضم إلينا</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="form-page join-page container my-5">
        <form class="form-one" method="POST" action="{{ route('frontend.albir-friends.registration-form.store', $slug) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            @if ($slug == 'beneficiaries_membership')
                <h3>عضوية المستحقين</h3>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            {!! Form::label('name', trans('dashboard.name')) !!}
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="الاسم">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            {!! Form::label('ident_num', trans('translation.ident_num')) !!}
                            <input type="number" name="ident_num" value="{{ old('ident_num') }}" placeholder="رقم الهوية">
                            @error('ident_num')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            {!! Form::label('num_f_members', 'عدد أفراد الأسرة') !!}
                            <input type="number" value="{{ old('num_f_members', 1) }}" min="0" step="1" dir="rtl" name="num_f_members"  placeholder="عدد افراد الاسرة">
                            @error('num_f_members')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <div class="form-control">
                                {!! Form::label('neighborhood', 'أختر الحي') !!}
                                <select name="neighborhood">
                                    <option selected value="">أختر الحي</option>
                                    @foreach ($neighborhoods as $key => $value)
                                        <option value="{{ $value }}" {{ ($value == old('neighborhood', $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('neighborhood')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            {!! Form::label('phone', 'رقم الجوال') !!}
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال للتواصل">
                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            {!! Form::label('email', 'البريد الإلكتروني') !!}
                            <input type="email" value="{{ old('email') }}" name="email"  placeholder="البريد الإلكتروني">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <div class="form-control">
                                {!! Form::label('ident_img', 'أصورة عن الهوية الوطنية') !!}
                                <input type="file" name="ident_img" accept=".jpg, .png, image/jpeg, image/png">
                                @error('ident_img')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <div class="form-control">
                                {!! Form::label('gendident_imger', 'إدخل كود التحقق') !!}
                                <input type="number" name="verification_code" placeholder="إدخل كود التحقق">
                                @error('verification_code')<span class="text-danger">{{ $message }}</span>@enderror
                                <h6 class="verfy-code"><span>رمز التحقق: {{ $verification_code }}</span></h6>
                                <input type="hidden" value="{{ $verification_code }}" name="code">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-control form-control-full">
                            {!! Form::submit(trans('dashboard.add'), ['class' => 'thm-btn dynamic-radius']) !!}
                        </div>
                    </div>
                </div>
            @elseif ($slug == 'donor_membership')
                <h3>عضوية المتبرعين</h3>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            {!! Form::label('name', trans('dashboard.name')) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            {!! Form::label('phone', trans('dashboard.phone')) !!}
                            {!! Form::tel('phone', old('phone'), ['class' => 'form-control']) !!}
                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            {!! Form::label('email', trans('dashboard.email')) !!}
                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'autocomplete' => 'email']) !!}
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <div class="form-control">
                                {!! Form::label('gender', trans('translation.gender')) !!}
                                {!! Form::select('gender', ['' => trans('translation.gender'), 'male' => trans('translation.male'), 'female' => trans('translation.female'), ], old('gender'), ['class' => 'valid']) !!}
                                @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-control form-control-full">
                            {!! Form::submit(trans('dashboard.add'), ['class' => 'thm-btn dynamic-radius']) !!}
                        </div>
                    </div>
                </div>
            @endif
        </form>
    </section>
@endsection
