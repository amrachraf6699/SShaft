@extends('dashboard.layouts.master')
@section('css')
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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.albir_friends') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('translation.general_assembly_members') }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
                    <!--div-->
					<div class="col-md-12">
						<div class="card card-primary">
							<div class="card-body">
                                {!! Form::open(['route' => ['dashboard.albir-friends.general-assembly-members.update', $general_assembly_members->key], 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('how_to_join', trans('translation.how_to_join')) !!}
                                            {!! Form::textarea('how_to_join', old('how_to_join', $general_assembly_members->how_to_join), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                            @error('how_to_join')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('joining_terms', trans('translation.joining_terms')) !!}
                                            {!! Form::textarea('joining_terms', old('joining_terms', $general_assembly_members->joining_terms), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                            @error('joining_terms')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('membership_benefits', trans('translation.membership_benefits')) !!}
                                            {!! Form::textarea('membership_benefits', old('membership_benefits', $general_assembly_members->membership_benefits), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                            @error('membership_benefits')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        {!! Form::label('img', trans('dashboard.img')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <input type="file" name="img" class="dropify" data-default-file="{{ $general_assembly_members->image_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('img')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-group pt-4">
                                    {!! Form::submit(trans('dashboard.save'), ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div><!-- bd -->
						</div><!-- bd -->
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
<!--Internal Fileuploads js-->
<script src="{{ URL::asset('dashboard_files/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('dashboard_files/assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            tabSize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
