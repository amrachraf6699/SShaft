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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.message_members') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('translation.individual_messaging') }}</span>
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
                            {{-- <div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{  route('dashboard.modules.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.modules') }}
                                    </a>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.message-members.individual-messaging.send'], 'method' => 'post']) !!}
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('send_method', trans('translation.send_method')) !!}
                                                {!! Form::select('send_method', ['email' => trans('dashboard.email'), 'phone_message' => trans('translation.phone_message'), ], old('send_method'), ['class' => 'form-control']) !!}
                                                @error('send_method')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('message_title', trans('translation.message_title')) !!}
                                                {!! Form::text('message_title', old('message_title'), ['class' => 'form-control']) !!}
                                                @error('message_title')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('sent_mail', trans('translation.sent_mail')) !!}
                                                {!! Form::email('sent_mail', old('sent_mail'), ['class' => 'form-control']) !!}
                                                @error('sent_mail')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('sent_phone', trans('web.phone')) !!}
                                                {!! Form::tel('sent_phone', old('sent_phone'), ['class' => 'form-control']) !!}
                                                @error('sent_phone')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('message', trans('dashboard.message')) !!}
                                                {!! Form::textarea('message', old('message'), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                                @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>

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
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
