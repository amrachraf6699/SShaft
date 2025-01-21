@extends('dashboard.layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('dashboard.sliders') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.show') }}</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="row row-sm">
                    <div class="col-xl-8 col-lg-12 col-md-12">
						<div class="card card-primary">
							<img class="card-img-top w-100 ht-400" src="{{ $slider->image_path }}" alt="{{ $slider->title }}">
							<div class="card-body text-center">
								<h4 class="card-title mb-3 text-primary tx-22 tx-bold">{{ $slider->title ? $slider->title : 'ـــــ' }}</h4>
							</div>
                            <div class="card-footer">
                                <div class="btn-icon-list">
                                    {{-- Slider edit --}}
                                    <a href="{{ route('dashboard.sliders.edit', $slider->id) }}" class="btn btn-primary">@lang('dashboard.update')</a>
                                    {{-- Slider delete --}}
                                    <form action="{{ route('dashboard.sliders.destroy', $slider->id) }}" method="post" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete" style="margin-right: 5px">@lang('dashboard.delete')</button>
                                    </form>
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
