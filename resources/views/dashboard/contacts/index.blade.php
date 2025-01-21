@extends('dashboard.layouts.master')
@section('css')

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('dashboard.contacts') }}</h4>
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
                        @include('dashboard.contacts.filter.filter')
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2" id="btnDeleteAll" data-toggle="modal" data-target="#deleteModal">
                                        <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @if($contacts->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2"><input name="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                                                <th class="py-2">#</th>
                                                <th class="py-2">{{ __('dashboard.message_status') }}</th>
                                                <th class="py-2">{{ __('dashboard.from') }}</th>
                                                <th class="py-2">{{ __('dashboard.subject') }}</th>
                                                <th class="py-2">{{ __('dashboard.email') }}</th>
                                                <th class="py-2">{{ __('dashboard.phone') }}</th>
                                                <th class="py-2">{{ __('dashboard.created_at') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contacts as $index => $contact)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$contact->id}}" class="box1"></td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-{{ $contact->status == 'is_read' ? 'success' : 'danger' }}">
                                                            {{  __('dashboard.' . $contact->status) }}
                                                        </span>
                                                    </td>
                                                    <td><a href="{{ route('dashboard.contacts.show', $contact->id) }}">{{ $contact->name }}</a></td>
                                                    <td>{{ $contact->subject }}</td>
                                                    <td>{{ $contact->email }}</td>
                                                    <td>{{ $contact->phone }}</td>
                                                    <td>{{ $contact->created_at->format('d-m-Y h:i a') }}</td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            {{-- contact show --}}
                                                            <a href="{{ route('dashboard.contacts.show', $contact->id) }}" class="btn btn-info btn-icon"><i class="typcn typcn-th-list"></i></a>
                                                            {{-- contact delete --}}
                                                            <form action="{{ route('dashboard.contacts.destroy', $contact->id) }}" method="post" style="display: inline-block">
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
                                                        {!! $contacts->appends(request()->input())->links() !!}
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

                    <form action="{{ route('dashboard.contacts.destroy_all') }}" method="POST">
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
