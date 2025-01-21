@extends('dashboard.layouts.master')
@section('css')

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.general_assembly_members') }}</h4>
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
                        @include('dashboard.general-assembly-members.filter.filter')
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dashboard.general-assembly-members.create') }}" class="btn btn-primary btn-with-icon btn-block">
                                        <i class="typcn typcn-plus ml-1"></i> {{ __('dashboard.add') }}
                                    </a>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2" id="btnDeleteAll" data-toggle="modal" data-target="#deleteModal">
                                    <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                </a>
                            </div>

                            <div class="table-responsive">
                                @if($members->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2"><input name="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                                                <th class="py-2">{{ __('translation.package_id') }}</th>
                                                <th class="py-2">{{ __('translation.membership_no') }}</th>
                                                <th class="py-2">{{ __('dashboard.name') }}</th>
                                                <th class="py-2">{{ __('dashboard.phone') }}</th>
                                                <th class="py-2">{{ __('dashboard.email') }}</th>
                                                <th class="py-2">{{ __('translation.gender') }}</th>
                                                <th class="py-2">{{ __('dashboard.status') }}</th>
                                                <th class="py-2">{{ __('translation.ident_num') }}</th>
                                                <th class="py-2">{{ __('translation.subscription_date') }}</th>
                                                <th class="py-2">{{ __('translation.expiry_date') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($members as $member)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$member->id}}" class="box1"></td>
                                                    <td>
                                                        <a href="{{ route('dashboard.packages.show', $member->package->id) }}">{{ $member->package->title }}</a>
                                                    </td>
                                                    <td>{{ $member->membership_no }}</td>
                                                    <td>{{ $member->full_name }}</td>
                                                    <td>{{ $member->phone }}</td>
                                                    <td>{{ $member->email }}</td>
                                                    <td>
                                                        @if ($member->gender == 'male')
                                                            <i class="text-purple las la-male la-2x"></i>
                                                        @elseif($member->gender == 'female')
                                                            <i class="text-pink las la-female la-2x"></i>
                                                        @elseif($member->gender == '')
                                                            <i class="text-primary las la-question la-2x"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-@if ($member->status == 'active')success @elseif($member->status == 'inactive')danger @elseif($member->status == 'awaiting_payment')warning @elseif($member->status == 'pending')warning @endif">{{ __('translation.' . $member->status) }}</span>
                                                    </td>
                                                    <td>{{ $member->ident_num }}
                                                        <br>
                                                        <a href="{{ $member->image_path }}" target="_blank"><i class="text-purple las la-link la-2x"></i></a>
                                                    </td>
                                                    <td>{{ $member->subscription_date }}</td>
                                                    <td>{{ $member->expiry_date }}</td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            @if ($member->status == 'active')
                                                                {{-- member certificate --}}
                                                                <a href="{{ route('frontend.certificate-of-general-assembly-member.show', $member->uuid) }}" target="__blank" class="btn btn-purple btn-icon"><i class="las la-certificate"></i></a>
                                                            @endif
                                                            {{-- member invoice --}}
                                                            <a href="{{ route('dashboard.general-assembly-members.show', $member->id) }}" class="btn btn-info btn-icon"><i class="las la-file-invoice"></i></a>
                                                            {{-- member edit --}}
                                                            <a href="{{ route('dashboard.general-assembly-members.edit', $member->id) }}" class="btn btn-primary btn-icon"><i class="typcn typcn-pencil"></i></a>
                                                            {{-- member delete --}}
                                                            <form action="{{ route('dashboard.general-assembly-members.destroy', $member->id) }}" method="post" style="display: inline-block">
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
                                                        {!! $members->appends(request()->input())->links() !!}
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

                    <form action="{{ route('dashboard.general-assembly-members.destroy_all') }}" method="POST">
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
