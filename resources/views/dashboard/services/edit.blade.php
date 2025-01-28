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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.services') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.update') }}</span>
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
                                    <a href="{{  route('dashboard.services.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.services') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.services.update', $service->id], 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('branch_id', 'الفروع (خيار متعدد)') !!}
                                            <select name="branchSelect" class="form-control select2 branchSelect" multiple="multiple">
                                                @foreach(App\Branch::pluck('id', 'name') as $key => $value)
                                                    <option value="{{ $value }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="branch_id" id="branchHiddenInput" value="{{ old('branch_id', $service->branch_id) }}">
                                            @error('branch_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('service_section_id', trans('translation.section')) !!}
                                            {!! Form::select('service_section_id', ['' => trans('dashboard.category_select')] + $sections->toArray(), old('service_section_id', $service->service_section_id), ['class' => 'form-control select2']) !!}
                                            @error('service_section_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('title', trans('dashboard.title')) !!}
                                            {!! Form::text('title', old('title', $service->title), ['class' => 'form-control']) !!}
                                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
<input name="how_does_the_service_work" type="hidden" value="default values here default values heredefault values heredefault values heredefault values here" />
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            {!! Form::label('how_does_the_service_work', trans('translation.how_does_the_service_work')) !!}--}}
{{--                                            {!! Form::textarea('how_does_the_service_work', old('how_does_the_service_work', $service->how_does_the_service_work), ['class' => 'form-control summernote', 'rows' => 4]) !!}--}}
{{--                                            @error('how_does_the_service_work')<span class="text-danger">{{ $message }}</span>@enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('content', trans('dashboard.content')) !!}
                                            {!! Form::textarea('content', old('content', $service->content), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                            @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                        {!! Form::label('quick_donation', trans('translation.quick_donation')) !!}
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="rdiobox">
                                            {!! Form::radio('quick_donation', 'included', (old('quick_donation', $service->quick_donation)) == 'included' ? 'checked' : '') !!}
                                            <span>{{ __('translation.yes') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('quick_donation', 'included', (old('quick_donation', $service->quick_donation)) == 'unlisted' ? 'checked' : '') !!}
                                            <span>{{ __('translation.no') }}</span>
                                        </label>
                                    </div>
                                    @error('quick_donation')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                        {!! Form::label('incoming_requests', trans('translation.incoming_requests')) !!}
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="rdiobox">
                                            {!! Form::radio('incoming_requests', 'accept', (old('incoming_requests', $service->incoming_requests)) == 'accept' ? 'checked' : '') !!}
                                            <span>{{ __('translation.yes') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('incoming_requests', 'not_accept', (old('incoming_requests', $service->incoming_requests)) == 'not_accept' ? 'checked' : '') !!}
                                            <span>{{ __('translation.no') }}</span>
                                        </label>
                                    </div>
                                    @error('incoming_requests')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                        {!! Form::label('price_value', trans('translation.price_value')) !!}
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="rdiobox">
                                            {!! Form::radio('price_value', 'fixed', (old('price_value', $service->price_value)) == 'fixed' ? 'checked' : '') !!}
                                            <span>{{ __('translation.fixed') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('price_value', 'variable', (old('price_value', $service->price_value)) == 'variable' ? 'checked' : '') !!}
                                            <span>{{ __('translation.variable') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('price_value', 'percent', (old('price_value', $service->price_value)) == 'percent' ? 'checked' : '') !!}
                                            <span>{{ __('translation.percent') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('price_value', 'multi', (old('price_value', $service->price_value)) == 'multi' ? 'checked' : '') !!}
                                            <span>{{ __('translation.multi') }}</span>
                                        </label>
                                    </div>
                                    @error('price_value')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                        {!! Form::label('by_individuals', trans('مضاعفة السعر (أي حاصل ضرب الكمية في السعر إذا كان السعر ثابت)')) !!}
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="rdiobox">
                                            {!! Form::radio('by_individuals', '1', (old('by_individuals', $service->by_individuals)) == 1 ? 'checked' : '') !!}
                                            <span>{{ __('translation.active') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('by_individuals', '0', (old('by_individuals', $service->by_individuals)) == 0 ? 'checked' : '') !!}
                                            <span>{{ __('translation.inactive') }}</span>
                                        </label>
                                    </div>
                                    @error('by_individuals')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('basic_service_value', trans('translation.basic_service_value')) !!}
                                            {!! Form::number('basic_service_value', old('basic_service_value', $service->basic_service_value), ['step' => '0.01', 'class' => 'form-control']) !!}
                                            @error('basic_service_value')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('target_value', trans('translation.target_value')) !!}
                                            {!! Form::number('target_value', old('target_value', $service->target_value), ['step' => '0.01', 'class' => 'form-control']) !!}
                                            @error('target_value')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div id="multiDiv">
                                    <div class="row mg-t-20">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('multiple_service_value_1', trans('translation.multiple_service_value_1')) !!}
                                                {!! Form::number('multiple_service_value_1', old('multiple_service_value_1', $service->multiple_service_value_1), ['step' => '0.01', 'class' => 'form-control']) !!}
                                                @error('multiple_service_value_1')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('multiple_service_value_2', trans('translation.multiple_service_value_2')) !!}
                                                {!! Form::number('multiple_service_value_2', old('multiple_service_value_2', $service->multiple_service_value_2), ['step' => '0.01', 'class' => 'form-control']) !!}
                                                @error('multiple_service_value_2')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('multiple_service_value_3', trans('translation.multiple_service_value_3')) !!}
                                                {!! Form::number('multiple_service_value_3', old('multiple_service_value_3', $service->multiple_service_value_3), ['step' => '0.01', 'class' => 'form-control']) !!}
                                                @error('multiple_service_value_3')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('number_of_accepted_services', trans('translation.number_of_accepted_services')) !!}
                                            {!! Form::number('number_of_accepted_services', old('number_of_accepted_services', $service->number_of_accepted_services), ['class' => 'form-control']) !!}
                                            @error('number_of_accepted_services')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0 tx-bold">
                                        {!! Form::label('deleted_at', trans('translation.deleted')) !!}
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="rdiobox">
                                            {!! Form::radio('deleted_at', 'yes', false, [old('deleted_at')]) !!}
                                            <span>{{ __('translation.deleted') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('deleted_at', 'no', true, [old('deleted_at')]) !!}
                                            <span>{{ __('translation.not_deleted') }}</span>
                                        </label>
                                    </div>
                                    @error('deleted_at')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        {!! Form::label('status', trans('dashboard.status')) !!}
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'active', (old('status', $service->status)) == 'active' ? 'checked' : '') !!}
                                            <span>{{ __('translation.active') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            {!! Form::radio('status', 'inactive', (old('status', $service->status)) == 'inactive' ? 'checked' : '') !!}
                                            <span>{{ __('translation.inactive') }}</span>
                                        </label>
                                    </div>
                                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <div class="row pt-4">
                                    <div class="col-12">
                                        {!! Form::label('img', trans('dashboard.cover-img')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <br>
                                        <input type="file" name="cover" class="dropify" data-default-file="{{ $service->cover_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-6">
                                        {!! Form::label('img', trans('dashboard.img')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <br>
                                        <input type="file" name="img" class="dropify" data-default-file="{{ $service->image_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                        @error('img')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-6">
                                        {!! Form::label('app_icon', trans('translation.icon_app')) !!}
                                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                                        <br>
                                        <input type="file" name="app_icon" class="dropify" data-default-file="{{ $service->icon_app }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
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
        console.log("{{$service->price_value}}")
        console.log($('input[name="price_value"]:checked').val())
        if ($('input[name="price_value"]:checked').val() == "multi") {
            console.log('test')
            $("#multiDiv").show();
        } else {
            $("#multiDiv").hide();
        }

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
<script>
    $('.branchSelect').select2({
        placeholder: "اختر الفرع"
    });

    var selectedBranches = $('#branchHiddenInput').val().split(',').filter(Boolean);
    $('.branchSelect').val(selectedBranches).trigger('change');

    $('.branchSelect').on('change', function() {
        var $select = $(this);
        var selectedValues = $select.val() || [];

        $('#branchHiddenInput').val(selectedValues.join(','));

        selectedValues.forEach(function(value) {
            $select.find(`option[value="${value}"]`).prop('disabled', true);
        });

        $select.select2({
            placeholder: "اختر الفرع"
        });
    });
    </script>
@endsection
