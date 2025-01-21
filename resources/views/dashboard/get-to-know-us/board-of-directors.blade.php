@extends('dashboard.layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.get_to_know_us') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('translation.board_of_directors') }}</span>
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
                                {!! Form::open(['route' => ['dashboard.get-to-know-us.board-of-directors.update', $board_of_directors->key], 'method' => 'post', 'files' => true]) !!}
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('value', trans('translation.board_of_directors')) !!}
                                            <p class="text-muted">{{ __('translation.ex_board_of_directors') }}</p>
                                            {!! Form::textarea('value', old('value', $board_of_directors->value), ['class' => 'form-control summernote', 'rows' => 4]) !!}
                                            @error('value')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::submit(trans('dashboard.save'), ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div><!-- bd -->
						</div><!-- bd -->
					</div>
					<!--/div-->
				</div>
				<!-- row closed -->

                <!-- row -->
				<div class="row row-sm">
                    <!--div-->
					<div class="col-md-12">
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dashboard.directors.create') }}" class="btn btn-primary btn-with-icon btn-block">
                                        <i class="typcn typcn-plus ml-1"></i> {{ __('dashboard.add') }}
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @if($directors->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2">{{ __('dashboard.img') }}</th>
                                                <th class="py-2">{{ __('dashboard.name') }}</th>
                                                <th class="py-2">{{ __('dashboard.job_title') }}</th>
                                                <th class="py-2">{{ __('translation.facebook_link') }}</th>
                                                <th class="py-2">{{ __('translation.twitter_link') }}</th>
                                                <th class="py-2">{{ __('translation.instagram_link') }}</th>
                                                <th class="py-2">{{ __('translation.linkedin_link') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($directors as $director)
                                                <tr>
                                                    <td>
                                                        <img alt="{{ $director->adjective . ' ' . $director->name }}" class="rounded avatar-md mr-2" src="{{ $director->image_path  }}">
                                                    </td>
                                                    <td>{{ $director->adjective . ' ' . $director->name }}</td>
                                                    <td>{{ $director->job_title }}</td>
                                                    <td>
                                                        @if ($director->facebook_link)
                                                            <a href="{{ $director->facebook_link }}" target="_blank">
                                                                <i class="icon ion-logo-facebook"></i>
                                                            </a>
                                                        @else
                                                            <i class="las la-times"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($director->twitter_link)
                                                            <a href="{{ $director->twitter_link }}" target="_blank">
                                                                <i class="icon ion-logo-twitter"></i>
                                                            </a>
                                                        @else
                                                            <i class="las la-times"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($director->instagram_link)
                                                            <a href="{{ $director->instagram_link }}" target="_blank">
                                                                <i class="icon ion-logo-instagram"></i>
                                                            </a>
                                                        @else
                                                            <i class="las la-times"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($director->linkedin_link)
                                                            <a href="{{ $director->linkedin_link }}" target="_blank">
                                                                <i class="icon ion-logo-linkedin"></i>
                                                            </a>
                                                        @else
                                                            <i class="las la-times"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            {{-- director edit --}}
                                                            <a href="{{ route('dashboard.directors.edit', $director->id) }}" class="btn btn-primary btn-icon"><i class="typcn typcn-pencil"></i></a>
                                                            {{-- director delete --}}
                                                            <form action="{{ route('dashboard.directors.destroy', $director->id) }}" method="post" style="display: inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-icon delete" style="margin-right: 5px"><i class="typcn typcn-delete"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="12">
                                                    <div class="float-right">
                                                        {!! $directors->appends(request()->input())->links() !!}
                                                    </div>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    <h4 class="text-center pb-4">{{ __('dashboard.no_data_found') }}</h4>
                                @endif
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
