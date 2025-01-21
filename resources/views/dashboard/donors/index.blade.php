@extends('dashboard.layouts.master')
@section('css')

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.donors') }}</h4>
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
                        @include('dashboard.donors.filter.filter')
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2" id="btnDeleteAll" data-toggle="modal" data-target="#deleteModal">
                                        <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @if($donors->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2"><input name="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                                                <th class="py-2">{{ __('translation.membership_no') }}</th>
                                                <th class="py-2">{{ __('dashboard.name') }}</th>
                                                <th class="py-2">{{ __('dashboard.phone') }}</th>
                                                <th class="py-2">{{ __('dashboard.email') }}</th>
                                                <th class="py-2">{{ __('translation.gender') }}</th>
                                                <th class="py-2">{{ __('dashboard.status') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($donors as $donor)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$donor->id}}" class="box1"></td>
                                                    <td>{{ $donor->membership_no }}</td>
                                                    <td>{{ $donor->name }}</td>
                                                    <td>{{ $donor->phone }}</td>
                                                    <td>{{ $donor->email }}</td>
                                                    <td>
                                                        @if ($donor->gender == 'male')
                                                            <i class="text-purple las la-male la-2x"></i>
                                                        @elseif($donor->gender == 'female')
                                                            <i class="text-pink las la-female la-2x"></i>
                                                        @elseif($donor->gender == '')
                                                            <i class="text-primary las la-question la-2x"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($donor->status == 'active')
                                                            <i class="text-success las la-check-circle la-2x"></i>
                                                        @else
                                                            <i class="text-warning las la-times-circle la-2x"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            {{-- donor edit --}}
                                                            <a href="{{ route('dashboard.donors.edit', $donor->id) }}" class="btn btn-primary btn-icon"><i class="typcn typcn-pencil"></i></a>
                                                            {{-- donor delete --}}
                                                            <form action="{{ route('dashboard.donors.destroy', $donor->id) }}" method="post" style="display: inline-block">
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
                                                        {!! $donors->appends(request()->input())->links() !!}
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

                    <form action="{{ route('dashboard.donors.destroy_all') }}" method="POST">
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
