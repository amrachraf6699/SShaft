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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.pending_donations') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.update') }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('bank_name', trans('translation.bank_name')) !!}
                                            <input type="text" value="{{ $donation->bank_name }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('bank_name', trans('translation.transfer_receipt')) !!}
                                            <a href="{{ $donation->transfer_receipt }}" target="_blank">
                                                <img src="{{ $donation->transfer_receipt }}" alt="{{ $donation->bank_name }}" width="100%">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('bank_name', trans('dashboard.payment_response')) !!}
                                            <textarea class="form-control" rows="7" dir="ltr" readonly>{{ json_decode($donation->response)->rrn ?? $donation->response }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- bd -->
                        </div>
                    </div>
                    <!--/div-->

                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{  route('dashboard.pending-donations.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.pending_donations') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.pending-donations.update', $donation->id], 'method' => 'post']) !!}
                                @csrf
                                @method('PATCH')

                                <div class="row mg-t-20">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        {!! Form::label('status', trans('dashboard.status')) !!}
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'pending', (old('status', $donation->status)) == 'pending' ? 'checked' : '') !!}
                                            <span>{{ __('translation.pending_payment') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'paid', (old('status', $donation->status)) == 'paid' ? 'checked' : '') !!}
                                            <span>{{ __('translation.paid') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'unpaid', (old('status', $donation->status)) == 'unpaid' ? 'checked' : '') !!}
                                            <span>{{ __('translation.unpaid') }}</span>
                                        </label>
                                    </div>
                                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="form-group pt-4">
                                    {!! Form::submit(trans('dashboard.save'), ['class' => 'btn btn-primary']) !!}
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
