@extends('dashboard.layouts.master')
@section('css')

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('dashboard.lift_centers') }}</h4>
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
                        @include('dashboard.lift-centers.filter.filter')
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    @if (auth()->user()->hasPermission('create_lift_centers'))
                                        <a href="{{ route('dashboard.lift-centers.create') }}" class="btn btn-primary btn-with-icon btn-block">
                                            <i class="typcn typcn-plus ml-1"></i> {{ __('dashboard.add') }}
                                        </a>
                                    @else
                                        <a href="{{ route('dashboard.welcome') }}" class="btn btn-primary btn-with-icon btn-block disabled">
                                            <i class="typcn typcn-plus ml-1"></i> {{ __('dashboard.add') }}
                                        </a>
                                    @endif
                                </div>
                                @if (auth()->user()->hasPermission('delete_lift_centers'))
                                    <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2" id="btnDeleteAll" data-toggle="modal" data-target="#deleteModal">
                                        <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2 disabled" data-toggle="modal">
                                        <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                    </a>
                                @endif
                            </div>

                            <div class="table-responsive">
                                @if($lift_centers->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2"><input name="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                                                <th class="py-2">#</th>
                                                <th class="py-2">{{ __('dashboard.img') }}</th>
                                                <th class="py-2">{{ __('dashboard.link') }}</th>
                                                <th class="py-2">{{ __('dashboard.created_at') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lift_centers as $index => $lift_center)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$lift_center->id}}" class="box1"></td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <img alt="{{ $lift_center->id }}" class="rounded avatar-md mr-2" src="{{ $lift_center->file_path }}">
                                                    </td>
                                                    <td>
                                                        <p id="demo{{ $lift_center->id }}" style="display: none;">{{ route('lift-centers.file', [$lift_center->id]) }}</p>
                                                        <button class="btn btn-icon btn-primary-gradient" onclick="copy('demo{{ $lift_center->id }}')"><i class="las la-copy la-2x"></i></button>
                                                    </td>
                                                    <td>{{ $lift_center->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            {{-- lift_center show --}}
                                                            <a href="{{ route('lift-centers.file', $lift_center->file) }}" target="_blank" class="btn btn-info btn-icon"><i class="typcn typcn-th-list"></i></a>
                                                            {{-- lift_center delete --}}
                                                            @if (auth()->user()->hasPermission('delete_lift_centers'))
                                                                <form action="{{ route('dashboard.lift-centers.destroy', $lift_center->id) }}" method="post" style="display: inline-block">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-icon delete" style="margin-right: 5px"><i class="typcn typcn-delete"></i></button>
                                                                </form>
                                                            @else
                                                                <button class="btn btn-danger btn-icon disabled"><i class="typcn typcn-delete"></i></button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="12">
                                                    <div class="float-right">
                                                        {!! $lift_centers->appends(request()->input())->links() !!}
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

                    <form action="{{ route('dashboard.lift-centers.destroy_all') }}" method="POST">
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

<script>
    function copy(element_id){
        var aux = document.createElement("div");
        aux.setAttribute("contentEditable", true);
        aux.innerHTML = document.getElementById(element_id).innerHTML;
        aux.setAttribute("onfocus", "document.execCommand('selectAll',false,null)");
        document.body.appendChild(aux);
        aux.focus();
        document.execCommand("copy");
        document.body.removeChild(aux);
    }
</script>
@endsection
