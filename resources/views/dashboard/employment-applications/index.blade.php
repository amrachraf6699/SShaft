@extends('dashboard.layouts.master')
@section('css')

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.employment_applications') }}</h4>
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
                        @include('dashboard.employment-applications.filter.filter')
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2" id="btnDeleteAll" data-toggle="modal" data-target="#deleteModal">
                                        <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @if($applications->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2"><input name="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                                                <th class="py-2">{{ __('translation.cv') }}</th>
                                                <th class="py-2">{{ __('translation.request_no') }}</th>
                                                <th class="py-2">{{ __('translation.full_name') }}</th>
                                                <th class="py-2">{{ __('dashboard.email') }}</th>
                                                <th class="py-2">{{ __('dashboard.phone') }}</th>
                                                <th class="py-2">{{ __('dashboard.city') }}</th>
                                                <th class="py-2">{{ __('translation.age') }}</th>
                                                <th class="py-2">{{ __('translation.ident_num') }}</th>
                                                <th class="py-2">{{ __('translation.gender') }}</th>
                                                <th class="py-2">{{ __('translation.qualification') }}</th>
                                                <th class="py-2">{{ __('translation.specialization') }}</th>
                                                <th class="py-2">{{ __('translation.do_you_work') }}</th>
                                                <th class="py-2">{{ __('translation.years_of_experience') }}</th>
                                                <th class="py-2">{{ __('translation.current_place_of_work') }}</th>
                                                <th class="py-2">{{ __('translation.about_your_experiences') }}</th>
                                                <th class="py-2">{{ __('dashboard.created_at') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applications as $application)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$application->id}}" class="box1"></td>
                                                    <td>
                                                        <a href="{{ $application->file_path }}" target="_blank">
                                                            <i class="text-info las la-file la-2x"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $application->request_no }}</td>
                                                    <td>{{ $application->full_name }}</td>
                                                    <td>{{ $application->email }}</td>
                                                    <td>{{ $application->phone }}</td>
                                                    <td>{{ $application->city }}</td>
                                                    <td>{{ $application->age }}</td>
                                                    <td>{{ $application->ident_num }}</td>
                                                    <td>
                                                        @if ($application->gender == 'male')
                                                            <i class="text-purple las la-male la-2x"></i>
                                                        @elseif($application->gender == 'female')
                                                            <i class="text-pink las la-female la-2x"></i>
                                                        @elseif($application->gender == '')
                                                            <i class="text-primary las la-question la-2x"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $application->qualification }}</td>
                                                    <td>{{ $application->specialization }}</td>
                                                    <td>
                                                        @if ($application->do_you_work == 'ok')
                                                            <i class="text-success las la-check-circle la-2x"></i>
                                                        @else
                                                            <i class="text-warning las la-times-circle la-2x"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $application->years_of_experience }}</td>
                                                    <td>{{ $application->current_place_of_work }}</td>
                                                    <td>{{ $application->about_your_experiences }}</td>
                                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            {{-- application delete --}}
                                                            <form action="{{ route('dashboard.employment-applications.destroy', $application->id) }}" method="post" style="display: inline-block">
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
                                                        {!! $applications->appends(request()->input())->links() !!}
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

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ __('dashboard.multiple_delete') }}
                        </h5>
                    </div>

                    <form action="{{ route('dashboard.employment-applications.destroy_all') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            {{ __('dashboard.warning_multiple_delete') }}
                            <input type="hidden" id="delete_all_id" name="ids" value=" ">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('dashboard.close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('dashboard.confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('js')
<script type="text/javascript">
    $(function() {
        $("#btnDeleteAll").click(function() {
            var selected = new Array();
            $("#datatable input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });
            if (selected.length <= 0) {
                $('#btnDeleteAll').removeAttr('data-target');
            } else {
                $('#deleteModal').modal('show');
                $('input[id="delete_all_id"]').val(selected);
            }
        });
    });
</script>
@endsection
