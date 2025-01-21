@extends('dashboard.layouts.master')
@section('css')

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.beneficiaries_requests') }}</h4>
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
                        @include('dashboard.beneficiaries-requests.filter.filter')
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dashboard.beneficiaries-requests.create') }}" class="btn btn-primary btn-with-icon btn-block">
                                        <i class="typcn typcn-plus ml-1"></i> {{ __('dashboard.add') }}
                                    </a>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2" id="btnDeleteAll" data-toggle="modal" data-target="#deleteModal">
                                    <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                </a>
                            </div>

                            <div class="table-responsive">
                                @if($beneficiaries_requests->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2"><input name="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                                                <th class="py-2">{{ __('dashboard.img') }}</th>
                                                <th class="py-2">كود الطلب</th>
                                                <th class="py-2">{{ __('dashboard.name') }}</th>
                                                <th class="py-2">{{ __('translation.ident_num') }}</th>
                                                <th class="py-2">{{ __('dashboard.phone') }}</th>
                                                <th class="py-2">{{ __('translation.target_value') }}</th>
                                                <th class="py-2">{{ __('translation.collected_value') }}</th>
                                                <th class="py-2">عدد أفراد الأسرة</th>
                                                <th class="py-2">{{ __('dashboard.status') }}</th>
                                                <th class="py-2">{{ __('dashboard.created_at') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($beneficiaries_requests as $beneficiaries_request)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$beneficiaries_request->id}}" class="box1"></td>
                                                    <td>
                                                        <img alt="{{ $beneficiaries_request->name }}" class="rounded avatar-md mr-2" src="{{ $beneficiaries_request->ident_image_path  }}">
                                                    </td>
                                                    <td>{{ $beneficiaries_request->membership_no }}</td>
                                                    <td>{{ $beneficiaries_request->ident_num }}</td>
                                                    <td>{{ $beneficiaries_request->name }}</td>
                                                    <td>{{ $beneficiaries_request->phone }}</td>
                                                    <td>{{ $beneficiaries_request->target_value . ' ' . __('dashboard.SAR') }}</td>
                                                    <td>{{ $beneficiaries_request->collected_value . ' ' . __('dashboard.SAR') }}</td>
                                                    <td>{{ $beneficiaries_request->num_f_members }}</td>
                                                    <td>
                                                        @if ($beneficiaries_request->status == 'active')
                                                            <i class="text-success las la-check-circle la-2x"></i>
                                                        @elseif  ($beneficiaries_request->status == 'pending')
                                                            <i class="text-warning las la-hourglass-half la-2x"></i>
                                                        @elseif  ($beneficiaries_request->status == 'inactive')
                                                            <i class="text-danger las la-times-circle la-2x"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $beneficiaries_request->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            <a href="{{ route('dashboard.beneficiaries.app-notifications.send', $beneficiaries_request->id) }}" class="btn btn-purple btn-icon"><i class="typcn typcn-bell"></i></a>
                                                            {{-- beneficiaries_request edit --}}
                                                            <a href="{{ route('dashboard.beneficiaries-requests.edit', $beneficiaries_request->id) }}" class="btn btn-primary btn-icon"><i class="typcn typcn-pencil"></i></a>
                                                            {{-- beneficiaries_request delete --}}
                                                            <form action="{{ route('dashboard.beneficiaries-requests.destroy', $beneficiaries_request->id) }}" method="post" style="display: inline-block">
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
                                                        {!! $beneficiaries_requests->appends(request()->input())->links() !!}
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

                    <form action="{{ route('dashboard.beneficiaries-requests.destroy_all') }}" method="POST">
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
