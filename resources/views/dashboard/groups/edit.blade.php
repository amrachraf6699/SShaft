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
							<h4 class="content-title mb-0 my-auto">{{ __('translation.user_groups') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.update') }}</span>
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
                            <div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{  route('dashboard.user-groups.index') }}" class="btn btn-primary btn-with-icon btn-block">
                                        {{ __('translation.user_groups') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => ['dashboard.user-groups.update', $group->id], 'method' => 'post']) !!}
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('name', trans('dashboard.title')) !!}
                                            {!! Form::text('name', old('name', $group->name), ['class' => 'form-control']) !!}
                                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mt-4">@lang('dashboard.permissions') <span class="text-danger">*</span></h5>

                                @php
                                    $models = [
                                                    'users', 'services', 'branches',
                                                ];
                                @endphp

                                <table class="table mt-4">
                                    <thead>
                                        <tr>
                                            <th>@lang('dashboard.model')</th>
                                            <th>@lang('dashboard.permissions')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($models as $model)
                                            <tr>
                                                <td>@lang('translation.' . $model)</td>
                                                <td>
                                                    {{-- <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                        <label class="m-0">
                                                            <input type="checkbox" value="" name="" class="all-roles">
                                                            <span class="label-text">@lang('dashboard.all')</span>
                                                        </label>
                                                    </div> --}}

                                                    @php
                                                        $permissionMaps = ['create', 'read', 'update', 'delete'];
                                                    @endphp

                                                    @foreach ($permissionMaps as $permissionMap)
                                                        <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                            <label class="m-0">
                                                                <input type="checkbox" value="{{ $permissionMap . '_' . $model }}" name="permissions[]" {{ $group->hasPermission( $permissionMap . '_' . $model) ? 'checked' : '' }} class="role">
                                                                <span class="label-text">@lang('dashboard.' . $permissionMap)</span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td>@lang('dashboard.lift_centers')</td>
                                            <td>
                                                {{-- <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="" name="" class="all-roles">
                                                        <span class="label-text">@lang('dashboard.all')</span>
                                                    </label>
                                                </div> --}}

                                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="create_lift_centers" {{ $group->hasPermission('create_lift_centers') ? 'checked' : '' }} name="permissions[]" class="role">
                                                        <span class="label-text">@lang('dashboard.create')</span>
                                                    </label>
                                                </div>
                                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="read_lift_centers" {{ $group->hasPermission('read_lift_centers') ? 'checked' : '' }} name="permissions[]" class="role">
                                                        <span class="label-text">@lang('dashboard.read')</span>
                                                    </label>
                                                </div>
                                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="delete_lift_centers" {{ $group->hasPermission('delete_lift_centers') ? 'checked' : '' }} name="permissions[]" class="role">
                                                        <span class="label-text">@lang('dashboard.delete')</span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>@lang('translation.donations')</td>
                                            <td>
                                                {{-- <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="" name="" class="all-roles">
                                                        <span class="label-text">@lang('dashboard.all')</span>
                                                    </label>
                                                </div> --}}

                                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="read_donations" {{ $group->hasPermission('read_donations') ? 'checked' : '' }} name="permissions[]" class="role">
                                                        <span class="label-text">@lang('dashboard.read')</span>
                                                    </label>
                                                </div>
                                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="update_donations" {{ $group->hasPermission('update_donations') ? 'checked' : '' }} name="permissions[]" class="role">
                                                        <span class="label-text">@lang('dashboard.update')</span>
                                                    </label>
                                                </div>
                                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="delete_donations" {{ $group->hasPermission('delete_donations') ? 'checked' : '' }} name="permissions[]" class="role">
                                                        <span class="label-text">@lang('dashboard.delete')</span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>@lang('dashboard.settings')</td>
                                            <td>
                                                {{-- <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="" name="" class="all-roles">
                                                        <span class="label-text">@lang('dashboard.all')</span>
                                                    </label>
                                                </div> --}}

                                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="read_settings" {{ $group->hasPermission('read_settings') ? 'checked' : '' }} name="permissions[]" class="role">
                                                        <span class="label-text">@lang('dashboard.read')</span>
                                                    </label>
                                                </div>
                                                <div class="animated-checkbox mx-2" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="update_settings" {{ $group->hasPermission('update_settings') ? 'checked' : '' }} name="permissions[]" class="role">
                                                        <span class="label-text">@lang('dashboard.update')</span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <!--<tr>-->
                                        <!--    <td>@lang('translation.albir_friends')</td>-->
                                        <!--    <td>-->
                                        <!--        {{-- <div class="animated-checkbox mx-2" style="display:inline-block;">-->
                                        <!--            <label class="m-0">-->
                                        <!--                <input type="checkbox" value="" name="" class="all-roles">-->
                                        <!--                <span class="label-text">@lang('dashboard.all')</span>-->
                                        <!--            </label>-->
                                        <!--        </div> --}}-->

                                        <!--        <div class="animated-checkbox mx-2" style="display:inline-block;">-->
                                        <!--            <label class="m-0">-->
                                        <!--                <input type="checkbox" value="read_albir_friends" {{ $group->hasPermission('read_albir_friends') ? 'checked' : '' }} name="permissions[]" class="role">-->
                                        <!--                <span class="label-text">@lang('dashboard.read')</span>-->
                                        <!--            </label>-->
                                        <!--        </div>-->
                                        <!--        <div class="animated-checkbox mx-2" style="display:inline-block;">-->
                                        <!--            <label class="m-0">-->
                                        <!--                <input type="checkbox" value="update_albir_friends" {{ $group->hasPermission('update_albir_friends') ? 'checked' : '' }} name="permissions[]" class="role">-->
                                        <!--                <span class="label-text">@lang('dashboard.update')</span>-->
                                        <!--            </label>-->
                                        <!--        </div>-->
                                        <!--    </td>-->
                                        <!--</tr>-->

                                        <!--<tr>-->
                                        <!--    <td>@lang('dashboard.contacts')</td>-->
                                        <!--    <td>-->
                                        <!--        {{-- <div class="animated-checkbox mx-2" style="display:inline-block;">-->
                                        <!--            <label class="m-0">-->
                                        <!--                <input type="checkbox" value="" name="" class="all-roles">-->
                                        <!--                <span class="label-text">@lang('dashboard.all')</span>-->
                                        <!--            </label>-->
                                        <!--        </div> --}}-->

                                        <!--        <div class="animated-checkbox mx-2" style="display:inline-block;">-->
                                        <!--            <label class="m-0">-->
                                        <!--                <input type="checkbox" value="read_contacts" {{ $group->hasPermission('read_contacts') ? 'checked' : '' }} name="permissions[]" class="role">-->
                                        <!--                <span class="label-text">@lang('dashboard.read')</span>-->
                                        <!--            </label>-->
                                        <!--        </div>-->
                                        <!--        <div class="animated-checkbox mx-2" style="display:inline-block;">-->
                                        <!--            <label class="m-0">-->
                                        <!--                <input type="checkbox" value="delete_contacts" {{ $group->hasPermission('delete_contacts') ? 'checked' : '' }} name="permissions[]" class="role">-->
                                        <!--                <span class="label-text">@lang('dashboard.delete')</span>-->
                                        <!--            </label>-->
                                        <!--        </div>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                    </tbody>
                                </table><!-- end of table -->

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
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Select2 js-->
<script src="{{ URL::asset('dashboard_files/assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $(function () {
        $(document).on('change', '.all-roles', function () {
            $(this).parents('tr').find('input[type="checkbox"]').prop('checked', this.checked);
        });

        $(document).on('change', '.role', function () {
            if (!this.checked) {
                $(this).parents('tr').find('.all-roles').prop('checked', this.checked);
            }
        });
    });
</script>
@endsection
