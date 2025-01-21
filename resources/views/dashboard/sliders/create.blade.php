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
							<h4 class="content-title mb-0 my-auto">{{ __('dashboard.sliders') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.add') }}</span>
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
                                    <a href="{{  route('dashboard.sliders.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('dashboard.sliders') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'dashboard.sliders.store', 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                
                                <div class="row mg-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('type', trans('dashboard.type')) !!}
                                            {!! Form::select('type', ['home' => 'home', 'section' => 'section'], old('type'), ['class' => 'form-control select2']) !!}
                                            @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('title', trans('dashboard.title')) !!}
                                            {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
                                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                        {!! Form::label('status', trans('dashboard.status')) !!}
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'active', true, [old('status')]) !!}
                                            <span>{{ __('translation.active') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'inactive', false, [old('status')]) !!}
                                            <span>{{ __('translation.inactive') }}</span>
                                        </label>
                                    </div>
                                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                        {!! Form::label('quick_donation', trans('translation.quick_donation_form')) !!}
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="rdiobox">
                                            {!! Form::radio('quick_donation', 'yes', false, [old('quick_donation')]) !!}
                                            <span>{{ __('translation.yes') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('quick_donation', 'no', true, [old('quick_donation')]) !!}
                                            <span>{{ __('translation.no') }}</span>
                                        </label>
                                    </div>
                                    @error('quick_donation')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('service_id', trans('translation.service')) !!}
                                            {!! Form::select('service_id', ['' => trans('translation.service')] + $services->toArray(), old('service_id'), ['class' => 'form-control select2']) !!}
                                            @error('service_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('url', trans('dashboard.url')) !!}
                                            {!! Form::text('url', old('url'), ['class' => 'form-control']) !!}
                                            @error('url')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <div class="col-12">
                                        {!! Form::label('img', trans('dashboard.img')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <br>
                                        <input type="file" name="img" class="dropify" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('img')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
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
