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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.general_assembly_members') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.update') }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{  route('dashboard.general-assembly-members.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.general_assembly_members') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.general-assembly-members.update', $member->id], 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('package_id', trans('translation.section')) !!}
                                            {!! Form::select('package_id', ['' => trans('translation.select')] + $packages->toArray(), old('package_id', $member->package_id), ['class' => 'form-control select2']) !!}
                                            @error('package_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('first_name', trans('translation.first_name')) !!}
                                            {!! Form::text('first_name', old('first_name', $member->first_name), ['class' => 'form-control']) !!}
                                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('last_name', trans('translation.last_name')) !!}
                                            {!! Form::text('last_name', old('last_name', $member->last_name), ['class' => 'form-control']) !!}
                                            @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-t-40 mg-b-40">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        {!! Form::label('gender', trans('translation.gender')) !!}
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="rdiobox">
                                            {!! Form::radio('gender', 'male', (old('gender', $member->gender)) == 'male' ? 'checked' : '') !!}
                                            <span>{{ __('translation.male') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('gender', 'female', (old('gender', $member->gender)) == 'female' ? 'checked' : '') !!}
                                            <span>{{ __('translation.female') }}</span>
                                        </label>
                                    </div>
                                    @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('phone', trans('dashboard.phone')) !!}
                                            {!! Form::tel('phone', old('phone', $member->phone), ['class' => 'form-control']) !!}
                                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('email', trans('dashboard.email')) !!}
                                            {!! Form::email('email', old('email', $member->email), ['class' => 'form-control', 'autocomplete' => 'email']) !!}
                                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('ident_num', trans('translation.ident_num')) !!}
                                            {!! Form::number('ident_num', old('ident_num', $member->ident_num), ['class' => 'form-control']) !!}
                                            @error('ident_num')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('subscription_date', trans('translation.subscription_date')) !!}
                                            {!! Form::date('subscription_date', old('subscription_date', $member->subscription_date), ['class' => 'form-control']) !!}
                                            @error('subscription_date')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <div class="col-12">
                                        {!! Form::label('attachments', trans('translation.ident_attachment')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <input type="file" name="attachments" class="dropify" data-default-file="{{ $member->image_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('attachments')<span class="text-danger">{{ $message }}</span>@enderror
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
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header py-3 d-flex"></div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.general-assembly-members.status', $member->id], 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('status', trans('dashboard.status')) !!}
                                            {!! Form::select('status', ['active' => trans('dashboard.active'), 'pending' => trans('translation.pending'), 'awaiting_payment' => trans('translation.awaiting_payment'), 'inactive' => trans('dashboard.inactive'), 'rejected' => trans('translation.rejected') ], old('status', $member->status), ['class' => 'form-control']) !!}
                                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
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
