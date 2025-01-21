@extends('frontend.layouts.app')

@section('content')
<section class="form-page container my-5">
    <form class="form-one gift-form" action="{{ route('frontend.verifyOtp') }}" method="POST">
        @csrf
        @method('POST')
        <h3>التحقق من رقم الجوال</h3>

        <div class="row">
            <input type="hidden" name="phone" readonly value="{{ $donor->phone }}">
            <div class="col-md-6 col-6">
                <input type="number" name="otp_code" value="{{ old('otp_code') }}" class="form-control" placeholder="ادخل كود التحقق المرسل علي جوالك">
                @error('otp_code')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="col-6">
                <div class="form-control form-control-full">
                    <input type="submit" class="thm-btn dynamic-radius" value="إرسال">
                </div>
            </div>

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
    </form>
</section>
@endsection
