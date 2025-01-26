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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.branches') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.update') }}</span>
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
                                    <a href="{{  route('dashboard.branches.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.branches') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.branches.update', $branch->id], 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('name', trans('dashboard.name')) !!}
                                            {!! Form::text('name', old('name', $branch->name), ['class' => 'form-control']) !!}
                                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('content', trans('dashboard.content')) !!}
                                            {!! Form::textarea('content', old('content', $branch->content), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                            @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('link_map_address', trans('dashboard.link_map_address')) !!}
                                            {!! Form::text('link_map_address', old('link_map_address', $branch->link_map_address), ['class' => 'form-control']) !!}
                                            @error('link_map_address')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        {!! Form::label('status', trans('dashboard.status')) !!}
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'active', (old('status', $branch->status)) == 'active' ? 'checked' : '') !!}
                                            <span>{{ __('translation.active') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'inactive', (old('status', $branch->status)) == 'inactive' ? 'checked' : '') !!}
                                            <span>{{ __('translation.inactive') }}</span>
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

                @if (request()->query('advanced'))
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="main-content-label">@lang('dashboard.advanced_settings')</div>
                                    <span class="badge badge-primary" style="background-color: #007bff;">
                                        @lang('dashboard.last_online_at'):
                                        {{ $branch->last_online_at ? Carbon\Carbon::parse($branch->last_online_at)->diffForHumans() : 'N/A' }}
                                    </span>
                                </div>
                                {!! Form::open(['route' => ['dashboard.branches.updateAdvancedSettings', $branch->id], 'method' => 'post']) !!}
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('is_refresh', trans('dashboard.is_refresh')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('is_refresh', 1, $branch->is_refresh == 1) !!}
                                                        @lang('dashboard.yes')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('is_refresh', 0, $branch->is_refresh == 0) !!}
                                                        @lang('dashboard.no')
                                                    </label>
                                                </div>
                                                @error('is_refresh')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('refresh_time', trans('dashboard.refresh_time')) !!}
                                                {!! Form::number('refresh_time', old('refresh_time', $branch->refresh_time), ['class' => 'form-control']) !!}
                                                @error('refresh_time')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('pinned_mode', trans('dashboard.pinned_mode')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('pinned_mode', 1, $branch->pinned_mode == 1) !!}
                                                        @lang('dashboard.enabled')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('pinned_mode', 0, $branch->pinned_mode == 0) !!}
                                                        @lang('dashboard.disabled')
                                                    </label>
                                                </div>
                                                @error('pinned_mode')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('quick_donations', trans('dashboard.quick_donations')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('quick_donations', 1, $branch->quick_donations == 1) !!}
                                                        @lang('dashboard.enabled')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('quick_donations', 0, $branch->quick_donations == 0) !!}
                                                        @lang('dashboard.disabled')
                                                    </label>
                                                </div>
                                                @error('quick_donations')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('nearpay', trans('dashboard.nearpay_settings')) !!}

                                                    {{-- @php
                                                        // Decode nearpay column or set default values if null
                                                        $nearpay = $branch->nearpay ? json_decode($branch->nearpay, true) : [
                                                            'enableReceiptUi' => false,
                                                            'finishTimeout' => 0,
                                                            'authType' => '',
                                                            'authValue' => '',
                                                            'env' => 'sandbox',
                                                        ];
                                                    @endphp --}}

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {!! Form::label('nearpay.enableReceiptUi', trans('dashboard.enable_receipt_ui')) !!}
                                                        <div>
                                                            <label>
                                                                {!! Form::radio('nearpay[enableReceiptUi]', 1, json_decode($branch->nearpay, true)['enableReceiptUi'] == 1) !!}
                                                                @lang('dashboard.yes')
                                                            </label>
                                                            <label>
                                                                {!! Form::radio('nearpay[enableReceiptUi]', 0, json_decode($branch->nearpay, true)['enableReceiptUi'] == 0) !!}
                                                                @lang('dashboard.no')
                                                            </label>
                                                        </div>
                                                        @error('nearpay.enableReceiptUi')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div>
                                                    {!! Form::label('nearpay.finishTimeout', trans('dashboard.finish_timeout')) !!}
                                                    {!! Form::number('nearpay[finishTimeout]', $nearpay['finishTimeout'] ?? 0, ['class' => 'form-control']) !!}
                                                    @error('nearpay.finishTimeout')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div>

                                                <div>
                                                    {!! Form::label('nearpay.authType', trans('dashboard.auth_type')) !!}
                                                    {!! Form::select('nearpay[authType]', ['email' => 'Email', 'mobile' => 'Mobile', 'jwt' => 'JWT'], $nearpay['authType'] ?? '', ['class' => 'form-control']) !!}
                                                    @error('nearpay.authType')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div>

                                                <div>
                                                    {!! Form::label('nearpay.authValue', trans('dashboard.auth_value')) !!}
                                                    {!! Form::text('nearpay[authValue]', $nearpay['authValue'] ?? '', ['class' => 'form-control']) !!}
                                                    @error('nearpay.authValue')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div>

                                                <div>
                                                    {!! Form::label('nearpay.env', trans('dashboard.env')) !!}
                                                    {!! Form::select('nearpay[env]', ['sandbox' => 'Sandbox', 'production' => 'Production'], $nearpay['env'] ?? 'sandbox', ['class' => 'form-control']) !!}
                                                    @error('nearpay.env')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group pt-4">
                                        {!! Form::submit(trans('dashboard.save'), ['class' => 'btn btn-primary']) !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
