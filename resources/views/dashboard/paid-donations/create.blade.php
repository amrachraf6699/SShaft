@extends('dashboard.layouts.master')
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('dashboard_files/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.accounts') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.add') }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{  route('dashboard.accounts.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.accounts') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'dashboard.paid-donations.store', 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('phone', trans('الجوال')) !!}
                                            {!! Form::number('phone', old('phone'), ['class' => 'form-control']) !!}
                                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('bank_transaction_id', trans('الرقم المرجعي')) !!}
                                            {!! Form::number('bank_transaction_id', old('bank_transaction_id'), ['class' => 'form-control']) !!}
                                            @error('bank_transaction_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('service_id', trans('الخدمة')) !!}
                                            {!! Form::select('service_id', App\Service::where('status', 'active')->pluck('title', 'id') ,old('service_id'), ['class' => 'form-control']) !!}
                                            @error('service_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('total_amount', trans('السعر الاجمالي')) !!}
                                            {!! Form::number('total_amount', old('total_amount'), ['class' => 'form-control']) !!}
                                            @error('total_amount')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('quantity', trans('العدد')) !!}
                                            {!! Form::number('quantity', old('quantity'), ['class' => 'form-control']) !!}
                                            @error('quantity')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row mg-t-20">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        {!! Form::label('payment_brand', trans('طريقة الدفع')) !!}
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="rdiobox">
                                            {!! Form::radio('payment_brand', 'MADA', true, [old('payment_brand')]) !!}
                                            <span>{{ __('MADA') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('payment_brand', 'VISA', false, [old('payment_brand')]) !!}
                                            <span>{{ __('VISA') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('payment_brand', 'MASTER', false, [old('payment_brand')]) !!}
                                            <span>{{ __('MASTER') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('payment_brand', 'APPLEPAY', false, [old('payment_brand')]) !!}
                                            <span>{{ __('APPLEPAY') }}</span>
                                        </label>
                                    </div>
                                    @error('payment_brand')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('branch_id', trans('الفرع')) !!}
                                            {!! Form::select('branch_id', App\Branch::where('status', 'active')->pluck('name', 'id') ,old('branch_id'), ['class' => 'form-control']) !!}
                                            @error('branch_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('created_at', trans('التاريخ')) !!}
                                            <input type="datetime-local" value="{{ old('created_at') }}" class="form-control" id="created_at" name="created_at">
                                            @error('created_at')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mg-t-20">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        {!! Form::label('send_sms', trans('إرسال الفاتورة')) !!}
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="rdiobox">
                                            {!! Form::radio('send_sms', 'yes', true, [old('send_sms')]) !!}
                                            <span>{{ __('أجل') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('send_sms', 'no', false, [old('send_sms')]) !!}
                                            <span>{{ __('لا') }}</span>
                                        </label>
                                    </div>
                                    @error('send_sms')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                                
                                
                                <div class="form-group pt-4">
                                    {!! Form::submit(trans('dashboard.add'), ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div><!-- bd -->
                        </div>
                    </div>
                    <!--/div-->
                </div>
                <!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Select2 js-->
<script src="{{ URL::asset('dashboard_files/assets/plugins/select2/js/select2.min.js') }}"></script>
@endsection
