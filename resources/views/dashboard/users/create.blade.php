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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.users') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.add') }}</span>
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
                                    <a href="{{  route('dashboard.users.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.users') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'dashboard.users.store', 'method' => 'post']) !!}
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('name', trans('dashboard.name')) !!}
                                            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('email', trans('dashboard.email')) !!}
                                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'autocomplete' => 'email']) !!}
                                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('password', trans('dashboard.password')) !!}
                                            {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'new-password']) !!}
                                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('confirm_password', trans('dashboard.confirm_password')) !!}
                                            {!! Form::password('confirm_password', ['class' => 'form-control', 'autocomplete' => 'new-password']) !!}
                                            @error('confirm_password')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-7">
                                        {{--role_id--}}
                                        <div class="form-group">
                                            <label>@lang('dashboard.role') </label>
                                            <select name="role_id" class="form-control select2" required>
                                                <option value="">@lang('translation.select') @lang('dashboard.role')</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $role->id == old('role_id') ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            {!! Form::label('user_status', trans('dashboard.user_status')) !!}
                                            {!! Form::select('user_status', ['active' => trans('dashboard.active'), 'inactive' => trans('dashboard.inactive'), ], old('user_status'), ['class' => 'form-control']) !!}
                                            @error('user_status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('dashboard.branch') </label>
                                            <select name="branch_id" class="form-control select2" required>
                                                <option value="">@lang('translation.select') @lang('dashboard.branch')</option>
                                                @php
                                                    $branches = \App\Branch::all();
                                                @endphp
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ $branch->id == old('branch_id') ? 'selected' : '' }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('phone', trans('dashboard.phone')) !!}
                                            {!! Form::tel('phone', old('phone'), ['class' => 'form-control']) !!}
                                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('gender', trans('translation.gender')) !!}
                                            {!! Form::select('gender', ['' => trans('translation.select'), 'male' => trans('translation.male'), 'female' => trans('translation.female'), ], old('gender'), ['class' => 'form-control']) !!}
                                            @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
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
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: '@lang('translation.select')',
        });
    });
</script>
@endsection
