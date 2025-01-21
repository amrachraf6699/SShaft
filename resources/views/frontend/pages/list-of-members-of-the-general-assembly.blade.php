@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ __('translation.general_assembly_members') }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ __('translation.general_assembly_members') }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section>
        <div class="container">
            <div class="row m-3 justify-content-center ">
                <div class="col-12 card">
                    <table class="table table-striped jambo_table text-center table-responsive d-lg-table">
                        <thead>
                            <tr class="headings  text-center">
                                <th class=""><img src="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}" alt="logo" class="ml-2"></th>
                                <th class="">{{ __('dashboard.name') }}</th>
                                <th class="">{{ __('translation.membership_type') }}</th>
                                <th class="">{{ __('translation.subscription_date') }}</th>
                                <th class="">{{ __('translation.expiry_date') }}</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            @if ($members->count() > 0)
                                @foreach ($members as $member)
                                    <tr class="">
                                        <td><img src="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}" alt="logo" class="ml-2"></td>
                                        <td>{{ $member->full_name }}</td>
                                        <td>{{ $member->package->title }}</td>
                                        <td>{{ $member->subscription_date }}</td>
                                        <td>{{ $member->expiry_date }}</td>
                                    </tr>
                                @endforeach
                            @else
                                    <h2>{{ __('dashboard.no_data_found') }}</h2>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {!! $members->appends(request()->input())->links() !!}
        </div>
    </section>
@endsection
