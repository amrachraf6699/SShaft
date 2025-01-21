
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
							<h4 class="content-title mb-0 my-auto">{{ __('dashboard.lift_centers') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.add') }}</span>
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
                                    <a href="{{  route('dashboard.lift-centers.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('dashboard.lift_centers') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'dashboard.lift-centers.store', 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        {!! Form::label('file', trans('dashboard.img')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <br>
                                        <input type="file" name="file" class="dropify" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('file')<span class="text-danger">{{ $message }}</span>@enderror
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
@endsection
