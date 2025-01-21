@extends('dashboard.layouts.master')
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('dashboard_files/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{ URL::asset('dashboard_files/assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('dashboard_files/assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.general_assembly_invoices') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.update') }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="row">
                    <div class="col-md-7">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('bank_name', trans('translation.bank_name')) !!}
                                            <input type="text" value="{{ $invoice->bank_name }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('bank_name', trans('translation.transfer_receipt')) !!}
                                            <a href="{{ $invoice->transfer_receipt }}" target="_blank">
                                                <img src="{{ $invoice->transfer_receipt }}" alt="{{ $invoice->bank_name }}" width="100%">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- bd -->
                        </div>
                    </div>
                    <!--/div-->

                    <div class="col-md-5">
                        <div class="card card-primary">
                            <div class="card-header py-3 d-flex"></div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.general-assembly-invoices.update', $invoice->id], 'method' => 'post']) !!}
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('invoice_status', trans('translation.invoice_status')) !!}
                                            {!! Form::select('invoice_status', ['paid' => trans('translation.paid'), 'awaiting_verification' => trans('translation.awaiting_verification'), 'unpaid' => trans('translation.unpaid')], old('invoice_status', $invoice->invoice_status), ['class' => 'form-control']) !!}
                                            @error('invoice_status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
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
<!--Internal Fileuploads js-->
<script src="{{ URL::asset('dashboard_files/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('dashboard_files/assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: '@lang('translation.select')',
        });
    });
</script>
@endsection
