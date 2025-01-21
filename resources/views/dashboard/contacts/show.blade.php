@extends('dashboard.layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('dashboard.contacts') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.show') }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="row row-sm">
					<div class="col-md-6">
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{  route('dashboard.contacts.index') }}" class="btn btn-primary btn-with-icon btn-block"><i class="las la-inbox ml-1"></i>  {{ __('dashboard.contacts') }}</a>
                                </div>
                            </div>
							<div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap table-hover" id="example1">
                                        <tbody>
                                            <tr>
                                                <th class="tx-primary">@lang('dashboard.from')</th>
                                                <td>
                                                    <i class="las la-reply ml-2"></i>
                                                    {{ $message->name }}
                                                    <br>
                                                    <small class="text-muted mr-4">{{ $message->email }}</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="tx-primary">@lang('dashboard.created_at')</th>
                                                <td><i class="las la-history ml-2"></i> {{ $message->created_at->format('d-m-Y h:i a') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="tx-primary">@lang('dashboard.subject')</th>
                                                <td><i class="las la-info ml-2"></i> {{ $message->subject }}</td>
                                            </tr>
                                            <tr>
                                                <th class="tx-primary">@lang('dashboard.message')</th>
                                                <td><i class="las la-sms ml-2"></i> {{ $message->message }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
								<div class="btn-icon-list">
                                    {{-- Message delete --}}
                                    <form action="{{ route('dashboard.contacts.destroy', $message->id) }}" method="post" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete" style="margin-right: 5px">@lang('dashboard.delete')</button>
                                    </form>
                                </div>
							</div>
						</div>
					</div>
					<!--/div-->

                    <!--div-->
                    <div class="col-md-6">
                        {!! Form::open(['route' => ['dashboard.contacts.update', $message->id], 'method' => 'post', 'files' => true]) !!}
                            @csrf
                            @method('PATCH')
                            <div class="card card-primary">
                                <div class="card-header py-3 d-flex">
                                    <div class="d-flex justify-content-between">
                                        {!! Form::submit('إرسال الرد', ['class' => 'btn btn-success btn-with-icon btn-block']) !!}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('message', trans('dashboard.message')) !!}
                                                {!! Form::textarea('message', old('message'), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                                @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
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
