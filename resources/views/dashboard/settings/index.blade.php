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
							<h4 class="content-title mb-0 my-auto"><i class="fas fa-cog text-muted"></i> {{ __('dashboard.settings') }}</h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
                @php
                    $setting = setting()
                @endphp
				<!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                {!! Form::open(['route' => 'dashboard.settings.update', 'method' => 'post', 'files' => true]) !!}
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('name', trans('dashboard.site_name')) !!}
                                                {!! Form::text('name', old('name', !empty($setting->name) ? $setting->name : ''), ['class' => 'form-control']) !!}
                                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('address', trans('dashboard.address')) !!}
                                                {!! Form::text('address', old('address', !empty($setting->address) ? $setting->address : ''), ['class' => 'form-control']) !!}
                                                @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                {!! Form::label('description', trans('dashboard.description')) !!}
                                                {!! Form::textarea('description', old('description', !empty($setting->description) ? $setting->description : ''), ['rows' => 3, 'class' => 'form-control']) !!}
                                                @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                {!! Form::label('keywords', trans('dashboard.keywords')) !!}
                                                {!! Form::textarea('keywords', old('keywords', !empty($setting->keywords) ? $setting->keywords : ''), ['rows' => 3, 'class' => 'form-control']) !!}
                                                @error('keywords')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('email', trans('dashboard.email')) !!}
                                                {!! Form::email('email', old('email', !empty($setting->email) ? $setting->email : ''), ['class' => 'form-control']) !!}
                                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('phone', trans('dashboard.phone')) !!}
                                                {!! Form::text('phone', old('phone', !empty($setting->phone) ? $setting->phone : ''), ['class' => 'form-control']) !!}
                                                @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('fax', trans('dashboard.fax')) !!}
                                                {!! Form::text('fax', old('fax', !empty($setting->fax) ? $setting->fax : ''), ['class' => 'form-control']) !!}
                                                @error('fax')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! Form::label('logo', trans('dashboard.logo')) !!}
                                            <p class="text-danger">* {{ trans('dashboard.accepted_formats') }} jpeg ,.jpg , png </p>
                                            <br>
                                            <input type="file" name="logo" class="dropify" data-default-file="{{ $setting->logo_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                            @error('logo')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('fav', trans('dashboard.fav')) !!}
                                            <p class="text-danger">* {{ trans('dashboard.accepted_formats') }} jpeg ,.jpg , png </p>
                                            <br>
                                            <input type="file" name="fav" class="dropify" data-default-file="{{ $setting->fav_path }}" accept=".jpg, .png, image/jpeg, image/png" data-height="70" />
                                            @error('fav')<span class="text-danger">{{ $message }}</span>@enderror
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

                <!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">@lang('dashboard.mail_template')</div>

                                <form action="{{ route('dashboard.settings.template_mail_update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('header_temp', trans('dashboard.header_temp')) !!}
                                                {!! Form::textarea('header_temp', old('header_temp', !empty($setting->header_temp) ? $setting->header_temp : ''), ['class' => 'form-control summernote']) !!}
                                                @error('header_temp')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('footer_temp', trans('dashboard.footer_temp')) !!}
                                                {!! Form::textarea('footer_temp', old('footer_temp', !empty($setting->footer_temp) ? $setting->footer_temp : ''), ['class' => 'form-control summernote']) !!}
                                                @error('footer_temp')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group pt-4">
                                        <button class="btn btn-primary">{{ trans('dashboard.save') }}</button>
                                    </div>
                                </form>
                            </div><!-- bd -->
                        </div>
                    </div>
                    <!--/div-->
                </div>
                <!-- row closed -->

                <!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">@lang('dashboard.sms_settings')</div>

                                <form action="{{ route('dashboard.settings.sms_setting_update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('sms_sender', trans('dashboard.sms_sender')) !!}
                                        </div>
                                        <div class="col-lg-9 mg-t-20 mg-lg-t-0">
                                            {!! Form::text('sms_sender', old('sms_sender', !empty($setting->sms_sender) ? $setting->sms_sender : ''), ['class' => 'form-control']) !!}
                                        </div>
                                        @error('sms_sender')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('sms_token', trans('dashboard.sms_token')) !!}
                                        </div>
                                        <div class="col-lg-9 mg-t-20 mg-lg-t-0">
                                            {!! Form::text('sms_token', old('sms_token', !empty($setting->sms_token) ? $setting->sms_token : ''), ['class' => 'form-control']) !!}
                                        </div>
                                        @error('sms_token')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group pt-4">
                                        <button class="btn btn-primary">{{ trans('dashboard.save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
				<!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">@lang('dashboard.mail_options')</div>

                                {!! Form::open(['route' => 'dashboard.settings.mail_update', 'method' => 'post']) !!}
                                    @csrf
                                    @method('POST')
                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('mail_mailer', trans('dashboard.mail_mailer')) !!}
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="rdiobox">
                                                {!! Form::radio('mail_mailer', 'smtp', (old('mail_mailer', !empty($setting->mail_mailer) ? $setting->mail_mailer : '')) == 'smtp' ? 'checked' : '') !!}
                                                <span>SMTP</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('mail_mailer', 'mail', (old('mail_mailer', !empty($setting->mail_mailer) ? $setting->mail_mailer : '')) == 'mail' ? 'checked' : '') !!}
                                                <span>MAIL</span>
                                            </label>
                                        </div>
                                        @error('mail_mailer')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('mail_encryption', trans('dashboard.mail_encryption')) !!}
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="rdiobox">
                                                {!! Form::radio('mail_encryption', 'tls', (old('mail_encryption', !empty($setting->mail_encryption) ? $setting->mail_encryption : '')) == 'tls' ? 'checked' : '') !!}
                                                <span>TLS</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('mail_encryption', 'ssl', (old('mail_encryption', !empty($setting->mail_encryption) ? $setting->mail_encryption : '')) == 'ssl' ? 'checked' : '') !!}
                                                <span>SSL</span>
                                            </label>
                                        </div>
                                        @error('mail_encryption')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('mail_host', trans('dashboard.mail_host')) !!}
                                        </div>
                                        <div class="col-lg-9 mg-t-20 mg-lg-t-0">
                                            {!! Form::text('mail_host', old('mail_host', !empty($setting->mail_host) ? $setting->mail_host : ''), ['class' => 'form-control']) !!}
                                        </div>
                                        @error('mail_host')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('mail_port', trans('dashboard.mail_port')) !!}
                                        </div>
                                        <div class="col-lg-9 mg-t-20 mg-lg-t-0">
                                            {!! Form::text('mail_port', old('mail_port', !empty($setting->mail_port) ? $setting->mail_port : ''), ['class' => 'form-control']) !!}
                                        </div>
                                        @error('mail_port')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('mail_username', trans('dashboard.mail_username')) !!}
                                        </div>
                                        <div class="col-lg-9 mg-t-20 mg-lg-t-0">
                                            {!! Form::text('mail_username', old('mail_username', !empty($setting->mail_username) ? $setting->mail_username : ''), ['class' => 'form-control']) !!}
                                        </div>
                                        @error('mail_username')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('mail_password', trans('dashboard.mail_password')) !!}
                                        </div>
                                        <div class="col-lg-9 mg-t-20 mg-lg-t-0">
                                            {!! Form::text('mail_password', old('mail_password', !empty($setting->mail_password) ? $setting->mail_password : ''), ['class' => 'form-control']) !!}
                                        </div>
                                        @error('mail_password')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('mail_from_address', trans('dashboard.mail_from_address')) !!}
                                        </div>
                                        <div class="col-lg-9 mg-t-20 mg-lg-t-0">
                                            {!! Form::email('mail_from_address', old('mail_from_address', !empty($setting->mail_from_address) ? $setting->mail_from_address : ''), ['class' => 'form-control']) !!}
                                        </div>
                                        @error('mail_from_address')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('mail_from_name', trans('dashboard.mail_from_name')) !!}
                                        </div>
                                        <div class="col-lg-9 mg-t-20 mg-lg-t-0">
                                            {!! Form::text('mail_from_name', old('mail_from_name', !empty($setting->mail_from_name) ? $setting->mail_from_name : ''), ['class' => 'form-control']) !!}
                                        </div>
                                        @error('mail_from_name')<span class="text-danger">{{ $message }}</span>@enderror
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

                <!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">@lang('dashboard.site_status')</div>

                                {!! Form::open(['route' => 'dashboard.settings.status', 'method' => 'post']) !!}
                                    @csrf
                                    @method('POST')
                                    <div class="row mg-t-10">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('status', trans('dashboard.status')) !!}
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="rdiobox">
                                                {!! Form::radio('status', 'open', (old('status', $setting->status)) == 'open' ? 'checked' : '') !!}
                                                <span>{{ __('dashboard.open') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                                {!! Form::radio('status', 'close', (old('status', $setting->status)) == 'close' ? 'checked' : '') !!}
                                                <span>{{ __('dashboard.closed') }}</span>
                                            </label>
                                        </div>
                                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="row mg-t-10" id="message" style="display: none">
                                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            {!! Form::label('message_maintenance', trans('dashboard.message_maintenance')) !!}
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="form-group">
                                                {!! Form::textarea('message_maintenance', old('message_maintenance', $setting->message_maintenance), ['class' => 'form-control summernote']) !!}
                                                @error('message_maintenance')<span class="text-danger">{{ $message }}</span>@enderror
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

                <!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">@lang('dashboard.social_media')</div>
                                {!! Form::open(['route' => 'dashboard.settings.social-media.update', 'method' => 'post']) !!}
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('facebook', trans('dashboard.facebook')) !!}
                                                {!! Form::text('facebook', old('facebook', !empty($setting->facebook) ? $setting->facebook : ''), ['class' => 'form-control']) !!}
                                                @error('facebook')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('twitter', trans('dashboard.twitter')) !!}
                                                {!! Form::text('twitter', old('twitter', !empty($setting->twitter) ? $setting->twitter : ''), ['class' => 'form-control']) !!}
                                                @error('twitter')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('instagram', trans('dashboard.instagram')) !!}
                                                {!! Form::text('instagram', old('instagram', !empty($setting->instagram) ? $setting->instagram : ''), ['class' => 'form-control']) !!}
                                                @error('instagram')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('snapchat', trans('dashboard.snapchat')) !!}
                                                {!! Form::text('snapchat', old('snapchat', !empty($setting->snapchat) ? $setting->snapchat : ''), ['class' => 'form-control']) !!}
                                                @error('snapchat')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('youtube', trans('dashboard.youtube')) !!}
                                                {!! Form::text('youtube', old('youtube', !empty($setting->youtube) ? $setting->youtube : ''), ['class' => 'form-control']) !!}
                                                @error('youtube')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('whatsapp', trans('dashboard.whatsapp')) !!}
                                                {!! Form::tel('whatsapp', old('whatsapp', !empty($setting->whatsapp) ? $setting->whatsapp : ''), ['class' => 'form-control']) !!}
                                                @error('whatsapp')<span class="text-danger">{{ $message }}</span>@enderror
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

                <!-- row -->
                {{-- <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">@lang('translation.section_id_on_the_home_page')</div>
                                {!! Form::open(['route' => 'dashboard.settings.section-id-on-the-home-page.update', 'method' => 'post']) !!}
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::select('section_id_on_the_home_page', ['' => trans('dashboard.category_select')] + $sections->toArray(), old('section_id_on_the_home_page', !empty($setting->section_id_on_the_home_page) ? $setting->section_id_on_the_home_page : ''), ['class' => 'form-control']) !!}
                                                @error('section_id_on_the_home_page')<span class="text-danger">{{ $message }}</span>@enderror
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
                </div> --}}
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
                                        {{ $setting->last_online_at ? Carbon\Carbon::parse($setting->last_online_at)->diffForHumans() : 'N/A' }}
                                    </span>
                                </div>
                                {!! Form::open(['route' => 'dashboard.settings.updateAdvancedSettings', 'method' => 'post']) !!}
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('is_refresh', trans('dashboard.is_refresh')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('is_refresh', 1, $setting->is_refresh == 1) !!}
                                                        @lang('dashboard.yes')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('is_refresh', 0, $setting->is_refresh == 0) !!}
                                                        @lang('dashboard.no')
                                                    </label>
                                                </div>
                                                @error('is_refresh')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('refresh_time', trans('dashboard.refresh_time')) !!}
                                                {!! Form::number('refresh_time', old('refresh_time', $setting->refresh_time), ['class' => 'form-control']) !!}
                                                @error('refresh_time')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('pinned_mode', trans('dashboard.pinned_mode')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('pinned_mode', 1, $setting->pinned_mode == 1) !!}
                                                        @lang('dashboard.enabled')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('pinned_mode', 0, $setting->pinned_mode == 0) !!}
                                                        @lang('dashboard.disabled')
                                                    </label>
                                                </div>
                                                @error('pinned_mode')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('quick_donations', trans('dashboard.quick_donations')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('quick_donations', 1, $setting->quick_donations == 1) !!}
                                                        @lang('dashboard.enabled')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('quick_donations', 0, $setting->quick_donations == 0) !!}
                                                        @lang('dashboard.disabled')
                                                    </label>
                                                </div>
                                                @error('quick_donations')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('show_last_online_at', trans('dashboard.show_last_online_at')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('show_last_online_at', 1, $setting->show_last_online_at == 1) !!}
                                                        @lang('dashboard.enabled')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('show_last_online_at', 0, $setting->show_last_online_at == 0) !!}
                                                        @lang('dashboard.disabled')
                                                    </label>
                                                </div>
                                                @error('show_last_online_at')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('branch_in_slider', trans('dashboard.branch_in_slider')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('branch_in_slider', 1, $setting->branch_in_slider == 1) !!}
                                                        @lang('dashboard.enabled')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('branch_in_slider', 0, $setting->branch_in_slider == 0) !!}
                                                        @lang('dashboard.disabled')
                                                    </label>
                                                </div>
                                                @error('branch_in_slider')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('branch_in_service', trans('dashboard.branch_in_service')) !!}
                                                <div>
                                                    <label>
                                                        {!! Form::radio('branch_in_service', 1, $setting->branch_in_service == 1) !!}
                                                        @lang('dashboard.enabled')
                                                    </label>
                                                    <label>
                                                        {!! Form::radio('branch_in_service', 0, $setting->branch_in_service == 0) !!}
                                                        @lang('dashboard.disabled')
                                                    </label>
                                                </div>
                                                @error('branch_in_service')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('nearpay', trans('dashboard.nearpay_settings')) !!}

                                                @php
                                                    // Decode nearpay column or set default values if null
                                                    $nearpay = $setting->nearpay ? json_decode($setting->nearpay, true) : [
                                                        'enableReceiptUi' => false,
                                                        'finishTimeout' => 0,
                                                        'authType' => '',
                                                        'authValue' => '',
                                                        'env' => 'sandbox',
                                                    ];
                                                @endphp

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {!! Form::label('nearpay.enableReceiptUi', trans('dashboard.enable_receipt_ui')) !!}
                                                        <div>
                                                            <label>
                                                                {!! Form::radio('nearpay[enableReceiptUi]', 1, json_decode($setting->nearpay, true)['enableReceiptUi'] == 1) !!}
                                                                @lang('dashboard.yes')
                                                            </label>
                                                            <label>
                                                                {!! Form::radio('nearpay[enableReceiptUi]', 0, json_decode($setting->nearpay, true)['enableReceiptUi'] == 0) !!}
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
<!--Internal Fileuploads js-->
<script src="{{ URL::asset('dashboard_files/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('dashboard_files/assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script>
    $(document).ready(function() {
        $('input[value="close"]').on('click', function() {
            $('#message').show();
        });
        $('input[value="open"]').on('click', function() {
            $('#message').css('display', 'none');
        });
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

        $('.select2').select2({
            placeholder: '@lang('dashboard.category_select')',
        });
    });
</script>
@endsection
