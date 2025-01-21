@extends('dashboard.layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('dashboard.users') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.show') }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-lg-6">
						<div class="card mg-b-20">
							<div class="card-body">
								<div class="pl-0">
									<div class="main-profile-overview">
										<div class="d-flex justify-content-between mg-b-20">
											<div>
												<h5 class="main-profile-name">{{ $user->name }}</h5>
                                                @foreach ($user->roles as $role)
												    <p class="main-profile-name-text d-inline">{{ $role->name }} {{ $loop->last ? '' : '-' }} </p>
                                                @endforeach
											</div>
										</div>
										{{-- <div class="row">
											<div class="col-md-4 col mb20">
												<h5>947</h5>
												<h6 class="text-small text-muted mb-0">Followers</h6>
											</div>
											<div class="col-md-4 col mb20">
												<h5>583</h5>
												<h6 class="text-small text-muted mb-0">Tweets</h6>
											</div>
											<div class="col-md-4 col mb20">
												<h5>48</h5>
												<h6 class="text-small text-muted mb-0">Posts</h6>
											</div>
										</div> --}}
										<hr class="mg-y-30">
										<div class="main-profile-social-list">
                                            <div class="media">
												<div class="media-icon bg-success-transparent text-success">
													<i class="las la-info"></i>
												</div>
												<div class="media-body">
                                                    <small class="badge badge-pill badge-{{ $user->user_status == 'active' ? 'success' : 'danger' }}">{{ __('dashboard.' . $user->user_status) }}</small>
												</div>
											</div>
											<div class="media">
												<div class="media-icon bg-success-transparent text-success">
													<i class="las la-envelope"></i>
												</div>
												<div class="media-body">
													<span>{{ $user->email }}</span>
												</div>
											</div>
                                            <div class="media">
												<div class="media-icon bg-success-transparent text-success">
													<i class="las la-mobile"></i>
												</div>
												<div class="media-body">
													<span>{{ $user->phone }}</span>
												</div>
											</div>
										</div>
									</div><!-- main-profile-overview -->
								</div>
							</div>
                            <div class="card-footer">
                                @if (auth()->user() && $user->id != auth()->user()->id)
                                    <div class="btn-icon-list">
                                        {{-- user status --}}
                                        @if (auth()->user()->hasPermission('update_users'))
                                            <a href="{{ route('dashboard.users.status', $user->id) }}" class="btn btn-{{ $user->user_status == 'active' ? 'success' : 'secondary' }}">
                                                {{ __('dashboard.' . $user->user_status) }}
                                            </a>
                                        @else
                                            <button class="btn btn-{{ $user->user_status == 'active' ? 'success' : 'secondary' }} disabled">{{ __('dashboard.' . $user->user_status) }}</button>
                                        @endif
                                        {{-- User edit --}}
                                        @if (auth()->user()->hasPermission('update_users'))
                                            <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-primary">@lang('dashboard.update')</a>
                                        @else
                                            <button class="btn btn-primary disabled">@lang('dashboard.update')</button>
                                        @endif
                                        {{-- User delete --}}
                                        @if (auth()->user()->hasPermission('delete_users'))
                                            <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete" style="margin-right: 5px">@lang('dashboard.delete')</button>
                                            </form>
                                        @else
                                            <button class="btn btn-danger disabled">@lang('dashboard.delete')</button>
                                        @endif
                                    </div>
                                @endif
                            </div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row row-sm">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-body">
                                        <label class="main-content-label tx-13 mg-b-20">{{ __('dashboard.permissions') }}</label>
										<div class="counter-status d-flex md-mb-0">
                                            <div class="media mb-4">
                                                <div class="media-body">
                                                    @foreach ($user->roles as $role)
                                                        @foreach ($role->permissions as $permission)
                                                            @php
                                                                $input = $permission->name;
                                                                $result = explode('_', $input);
                                                            @endphp
                                                            <a class="d-inline-block ml-2 mt-2 badge badge-info-transparent p-2" href="javascript:void(0)" style="font-size: .8rem !important;">
                                                                {{-- {{ '# ' . __('dashboard.' . $permission->name) }} --}}
                                                                {{ '# ' . __('dashboard.' . $result[0]) . ' ' . __('translation.' . $result[1]) }}
                                                            </a>
                                                        @endforeach
                                                    @endforeach
                                                    {{-- @if ($user->permissions)
                                                    @endif --}}
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

@endsection
