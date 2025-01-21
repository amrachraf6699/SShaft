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
        <form class="form-one" method="POST" action="{{ route('frontend.general-assembly-members.store', $package->slug) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <h3>انضم إلينا </h3>
            <div class="row">
                <input type="hidden" name="package_id" value="{{ old('package_id', $package->id) }}">
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        {!! Form::label('first_name', trans('translation.first_name')) !!}
                        {!! Form::text('first_name', old('first_name'), ['class' => 'form-control']) !!}
                        @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        {!! Form::label('last_name', trans('translation.last_name')) !!}
                        {!! Form::text('last_name', old('last_name'), ['class' => 'form-control']) !!}
                        @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <div class="form-control">
                            {!! Form::label('gender', trans('translation.gender')) !!}
                            {!! Form::select('gender', ['' => trans('translation.gender'), 'male' => trans('translation.male'), 'female' => trans('translation.female'), ], old('gender'), ['class' => 'valid']) !!}
                            @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        {!! Form::select('gender', ['' => trans('translation.gender'), 'male' => trans('translation.male'), 'female' => trans('translation.female'), ], old('gender'), ['class' => 'form-control valid']) !!}
                        {!! Form::label('gender', trans('translation.gender')) !!}
                        @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                    </div> --}}
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        {!! Form::label('phone', trans('dashboard.phone')) !!}
                        {!! Form::tel('phone', old('phone'), ['class' => 'form-control', 'placeholder' => '05xxxxxxxx']) !!}
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

                <div class="col-md-6 col-12">
                    <div class="form-group">
                        {!! Form::label('ident_num', trans('translation.ident_num')) !!}
                        {!! Form::number('ident_num', old('ident_num'), ['class' => 'form-control']) !!}
                        @error('ident_num')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="col-md-12 col-12">
                    <div class="form-group">
                        {!! Form::label('payment_ways', trans('translation.payment_ways')) !!}
                        {!! Form::select('payment_ways', ['bank_transfer' => trans('translation.bank_transfer'), 'credit_card' => trans('translation.credit_card'), ], old('payment_ways'), ['class' => 'valid']) !!}
                        @error('payment_ways')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <span>صورة عن الهوية الوطنية  :</span>
                        <input type="file" name="attachments" class="form-control">
                        @error('attachments')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

            <div class="col-12">
                <div class="form-control form-control-full">
                    {!! Form::submit(trans('dashboard.add'), ['class' => 'thm-btn dynamic-radius']) !!}
                </div>
            </div>
        </form>
    </section>
@endsection
