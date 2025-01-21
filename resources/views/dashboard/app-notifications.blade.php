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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.app-notifications') }}</h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.app-notifications.store'], 'method' => 'post', 'files' => true]) !!}
                                @csrf

                                <div class="row mg-t-40">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::select('type', ['' => trans('translation.select'), 'active' => trans('dashboard.all'), 'inactive' => 'مخصص'], old('type'), ['class' => 'form-control']) !!}
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
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('date', trans('dashboard.date')) !!}
                                            {!! Form::date('date', old('date'), ['class' => 'form-control']) !!}
                                            @error('date')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('time', trans('dashboard.time')) !!}
                                            {!! Form::time('time', old('time'), ['class' => 'form-control']) !!}
                                            @error('time')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('content', trans('dashboard.content')) !!}
                                            {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => 4, 'id' => 'mytextarea']) !!}
                                            @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row pt-4">
                                    <div class="col-6">
                                        {!! Form::label('img', trans('dashboard.img')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <input type="file" name="img" class="dropify" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('img')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-6">
                                        {!! Form::label('app_icon', trans('translation.icon_app')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <input type="file" name="app_icon" class="dropify" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('app_icon')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div> --}}

                                <div class="form-group pt-4">
                                    {!! Form::submit(trans('dashboard.send'), ['class' => 'btn btn-primary']) !!}
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
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '#mytextarea',
            height: 300,
            plugins: 'lists code emoticons',
            toolbar: 'undo redo | styleselect | bold italic | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'outdent indent | numlist bullist | emoticons',
            emoticons_append: {
                custom_mind_explode: {
                keywords: ['brain', 'mind', 'explode', 'blown'],
                char: '🤯'
                }
            }
        });
    });
</script>
@endsection
