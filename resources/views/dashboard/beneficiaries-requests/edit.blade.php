@extends('dashboard.layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('dashboard_files/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('dashboard_files/assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('dashboard_files/assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <style>
        #multiDiv {
            display: none;
        }
    </style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.beneficiaries_requests') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.update') }}</span>
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
                                            {!! Form::label('membership_no', 'كود الطلب') !!}
                                            <input type="text" value="{{ $beneficiaries_request->membership_no }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('name', trans('dashboard.name')) !!}
                                            <input type="text" value="{{ $beneficiaries_request->name }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('ident_num', trans('translation.ident_num')) !!}
                                            <input type="text" value="{{ $beneficiaries_request->ident_num }}" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('email', trans('dashboard.email')) !!}
                                            <input type="text" value="{{ $beneficiaries_request->email }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('phone', trans('dashboard.phone')) !!}
                                            <input type="text" value="{{ $beneficiaries_request->phone }}" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('neighborhood', trans('dashboard.neighborhood')) !!}
                                            <input type="text" value="{{ $beneficiaries_request->neighborhood }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('num_f_members', 'عدد أفراد الأسرة') !!}
                                            <input type="text" value="{{ $beneficiaries_request->num_f_members }}" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('bank_name', trans('translation.ident_attachment')) !!}
                                            <a href="{{ $beneficiaries_request->ident_image_path }}" target="_blank">
                                                <img src="{{ $beneficiaries_request->ident_image_path }}" alt="{{ $beneficiaries_request->membership_no }}" width="100%">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- bd -->
                        </div>
                    </div>
                    <!--/div-->

                    <div class="col-md-8">
                        <div class="col-md-12">
                            <div class="card card-purple">
                                <div class="card-body">
                                    {!! Form::open(['route' => ['dashboard.beneficiaries-requests.update-status', $beneficiaries_request->id], 'method' => 'post']) !!}
                                    @csrf
                                    @method('PATCH')

                                    <div class="row mg-t-20">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('status', trans('dashboard.status')) !!}
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="rdiobox">
                                                {!! Form::radio('status', 'pending', (old('status', $beneficiaries_request->status)) == 'pending' ? 'checked' : '') !!}
                                                <span>{{ __('translation.pending') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="rdiobox">
                                                {!! Form::radio('status', 'active', (old('status', $beneficiaries_request->status)) == 'active' ? 'checked' : '') !!}
                                                <span>{{ __('translation.active') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('status', 'inactive', (old('status', $beneficiaries_request->status)) == 'inactive' ? 'checked' : '') !!}
                                                <span>{{ __('translation.inactive') }}</span>
                                            </label>
                                        </div>
                                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="form-group pt-4">
                                        {!! Form::submit(trans('dashboard.save'), ['class' => 'btn btn-purple btn-block']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div><!-- bd -->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header py-3 d-flex">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{  route('dashboard.beneficiaries-requests.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                            {{ __('translation.beneficiaries_requests') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['route' => ['dashboard.beneficiaries-requests.update', $beneficiaries_request->id], 'method' => 'post', 'files' => true]) !!}
                                    @csrf
                                    @method('PATCH')

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                {!! Form::label('service_section_id', trans('translation.section')) !!}
                                                {!! Form::select('service_section_id', ['' => trans('dashboard.category_select')] + $sections->toArray(), old('service_section_id', $beneficiaries_request->service_section_id), ['class' => 'form-control select2']) !!}
                                                @error('service_section_id')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('publish_status', 'حالة النشر') !!}
                                                {!! Form::select('publish_status', ['' => trans('translation.select'), 'show' => 'عرض', 'hide' => 'إخفاء', ], old('publish_status', $beneficiaries_request->publish_status), ['class' => 'form-control']) !!}
                                                @error('publish_status')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('title', trans('dashboard.title')) !!}
                                                {!! Form::text('title', old('title', $beneficiaries_request->title), ['class' => 'form-control']) !!}
                                                @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('content', trans('dashboard.content')) !!}
                                                {!! Form::textarea('content', old('content', $beneficiaries_request->content), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                                @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row mg-t-20">
                                        <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                            {!! Form::label('quick_donation', trans('translation.quick_donation')) !!}
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="rdiobox">
                                                {!! Form::radio('quick_donation', 'included', (old('quick_donation', $beneficiaries_request->quick_donation)) == 'included' ? 'checked' : '') !!}
                                                <span>{{ __('translation.yes') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('quick_donation', 'included', (old('quick_donation', $beneficiaries_request->quick_donation)) == 'unlisted' ? 'checked' : '') !!}
                                                <span>{{ __('translation.no') }}</span>
                                            </label>
                                        </div>
                                        @error('quick_donation')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div> --}}

                                    {{-- <div class="row mg-t-20">
                                        <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                            {!! Form::label('incoming_requests', trans('translation.incoming_requests')) !!}
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="rdiobox">
                                                {!! Form::radio('incoming_requests', 'accept', (old('incoming_requests', $beneficiaries_request->incoming_requests)) == 'accept' ? 'checked' : '') !!}
                                                <span>{{ __('translation.yes') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('incoming_requests', 'not_accept', (old('incoming_requests', $beneficiaries_request->incoming_requests)) == 'not_accept' ? 'checked' : '') !!}
                                                <span>{{ __('translation.no') }}</span>
                                            </label>
                                        </div>
                                        @error('incoming_requests')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div> --}}

                                    <div class="row mg-t-20">
                                        <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                            {!! Form::label('price_value', trans('translation.price_value')) !!}
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="rdiobox">
                                                {!! Form::radio('price_value', 'fixed', (old('price_value', $beneficiaries_request->price_value)) == 'fixed' ? 'checked' : '') !!}
                                                <span>{{ __('translation.fixed') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('price_value', 'variable', (old('price_value', $beneficiaries_request->price_value)) == 'variable' ? 'checked' : '') !!}
                                                <span>{{ __('translation.variable') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('price_value', 'percent', (old('price_value', $beneficiaries_request->price_value)) == 'percent' ? 'checked' : '') !!}
                                                <span>{{ __('translation.percent') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('price_value', 'multi', (old('price_value', $beneficiaries_request->price_value)) == 'multi' ? 'checked' : '') !!}
                                                <span>{{ __('translation.multi') }}</span>
                                            </label>
                                        </div>
                                        @error('price_value')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-20">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('basic_service_value', trans('translation.basic_service_value')) !!}
                                                {!! Form::number('basic_service_value', old('basic_service_value', $beneficiaries_request->basic_service_value), ['step' => '0.01', 'class' => 'form-control']) !!}
                                                @error('basic_service_value')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('target_value', trans('translation.target_value')) !!}
                                                {!! Form::number('target_value', old('target_value', $beneficiaries_request->target_value), ['step' => '0.01', 'class' => 'form-control']) !!}
                                                @error('target_value')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div id="multiDiv">
                                        <div class="row mg-t-20">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('multiple_service_value_1', trans('translation.multiple_service_value_1')) !!}
                                                    {!! Form::number('multiple_service_value_1', old('multiple_service_value_1', $beneficiaries_request->multiple_service_value_1), ['step' => '0.01', 'class' => 'form-control']) !!}
                                                    @error('multiple_service_value_1')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('multiple_service_value_2', trans('translation.multiple_service_value_2')) !!}
                                                    {!! Form::number('multiple_service_value_2', old('multiple_service_value_2', $beneficiaries_request->multiple_service_value_2), ['step' => '0.01', 'class' => 'form-control']) !!}
                                                    @error('multiple_service_value_2')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('multiple_service_value_3', trans('translation.multiple_service_value_3')) !!}
                                                    {!! Form::number('multiple_service_value_3', old('multiple_service_value_3', $beneficiaries_request->multiple_service_value_3), ['step' => '0.01', 'class' => 'form-control']) !!}
                                                    @error('multiple_service_value_3')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pt-4">
                                        <div class="col-6">
                                            {!! Form::label('img', trans('dashboard.img')) !!}
                                            <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                            <input type="file" name="img" class="dropify" data-default-file="{{ $beneficiaries_request->image_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                            @error('img')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-6">
                                            {!! Form::label('app_icon', trans('translation.icon_app')) !!}
                                            <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                            <input type="file" name="app_icon" class="dropify" data-default-file="{{ $beneficiaries_request->icon_app }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                            @error('app_icon')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group pt-4">
                                        {!! Form::submit(trans('dashboard.save'), ['class' => 'btn btn-primary']) !!}
                                    </div>

                                    {!! Form::close() !!}
                                </div><!-- bd -->
                            </div>
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

        // if ({{ $beneficiaries_request->price_value == "multi" }}) {
        //     $("#multiDiv").show();
        // } else {
        //     $("#multiDiv").hide();
        // }

        $('input[name="price_value"]').on('change', function() {
            var type = $(this).val();
            if (type == "multi") {
                $("#multiDiv").show();
            } else {
                $("#multiDiv").hide();
            }
        });
    });
</script>
@endsection
