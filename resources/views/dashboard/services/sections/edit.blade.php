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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.services') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('translation.sections') }}</span><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.update') }}</span>
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
                                    <a href="{{  route('dashboard.service-sections.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.sections') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.service-sections.update', $section->id], 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('title', trans('dashboard.title')) !!}
                                            {!! Form::text('title', old('title', $section->title), ['class' => 'form-control']) !!}
                                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('desc', trans('dashboard.desc')) !!}
                                            {!! Form::text('desc', old('desc'), ['class' => 'form-control']) !!}
                                            @error('desc')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        {!! Form::label('parent_id', trans('translation.parent_id')) !!}
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="checkbox">
                                            @php
                                                $parantable_sections = \App\ServiceSection::where('status', 'active')->where('parent_id', '=', NULL)->get();
                                            @endphp
                                            <div class="form-group">
                                                <select name="parent_id" class="form-control select2">
                                                    @if ($section->parent_id)
                                                        @php
                                                            $active_section = \App\ServiceSection::where('status', 'active')->where('id', '=', $section->parent_id)->first();
                                                        @endphp
                                                        <option value="{{ $active_section->id }}" {{ $active_section->id == old('parent_id') ? 'selected' : '' }}>{{ $active_section->title }}</option>
                                                    @else
                                                        <option value="">@lang('translation.parent_section_select')</option>
                                                    @endif
                                                    @foreach ($parantable_sections as $pSection)
                                                        @if ($section->parent_id != $pSection->id)
                                                            <option value="{{ $pSection->id }}" {{ $pSection->id == old('parent_id') ? 'selected' : '' }}>{{ $pSection->title }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        {!! Form::label('status', trans('dashboard.status')) !!}
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'active', (old('status', $section->status)) == 'active' ? 'checked' : '') !!}
                                            <span>{{ __('translation.active') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'inactive', (old('status', $section->status)) == 'inactive' ? 'checked' : '') !!}
                                            <span>{{ __('translation.inactive') }}</span>
                                        </label>
                                    </div>
                                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-12">
                                        {!! Form::label('img', trans('dashboard.cover-img')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <br>
                                        <input type="file" name="cover" class="dropify" data-default-file="{{ $section->cover_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('img')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-12">
                                        {!! Form::label('img', trans('dashboard.image-img')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <br>
                                        <input type="file" name="image" class="dropify" data-default-file="{{ $section->image_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('img')<span class="text-danger">{{ $message }}</span>@enderror
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
@endsection
