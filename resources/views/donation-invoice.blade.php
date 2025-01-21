<!DOCTYPE html>
<html>
	<head>
        @php
            $setting = setting()
        @endphp
		<meta charset="utf-8" />
		<title>{{ $setting->name }} {{ !empty($pageTitle) ? '» ' . $pageTitle : '' }}</title>
        <!-- favicons Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">

        <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/fontawesome-all.min.css') }}">
        <!-- template styles -->
        <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/rtl.css') }}">
		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
        @include('partials._sessionSuccess')
        @include('partials._sessionError')
		<div class="invoice-box rtl">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="{{ $setting->logo_path }}" style="width: 100%; max-width: 300px" />
								</td>

								<td>
									{{ __('translation.donation_type') }}: {{ __('translation.' . $donation->donation_type) }}<br />
									{{ __('translation.membership_no') }}: {{ $donation->donor->membership_no ?? __('translation.null') }}<br />
									{{ __('translation.invoice_date') }}: {{ $donation->created_at->format('d/m/Y') }}<br />
									{{ __('translation.invoice_status') }}: {{ __('translation.' . $donation->status) }}<br />
									<img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ route('donation-invoice.show', $donation->donation_code) }}" alt="qr-code" height="auto" style="margin-top: 10px;">
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									{{ $setting->name }}<br />
									{{ $setting->address }}<br />
									{{ $setting->email }}<br />
                                    {{ $setting->phone }}
								</td>

								<td>
									{{ __('dashboard.phone') }}: {{ $donation->donor->phone ?? __('translation.null') }}<br />
                                    {{ __('dashboard.name') }}: {{ $donation->donor->name ?? '--- --- --- --' }}<br />
									{{ __('dashboard.email') }}: {{ $donation->donor->email ?? '--- --- --- --' }}<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>{{ __('translation.payment_ways') }}</td>

					<td>{{ __('translation.donation_code') }}</td>
				</tr>

				<tr class="details">
				    @php
				        $payment_brand = $donation->payment_brand == 'SPAN' ? 'MADA' : $donation->payment_brand;
				    @endphp
					<td>{{ $donation->payment_ways === 'bank_transfer' ? __('translation.' . $donation->payment_ways) : $payment_brand }}</td>

					<td>{{ $donation->donation_code }}</td>
			    </tr>

               @if ($donation->donation_type === 'gift')
                    <tr class="heading">
                        <td>{{ __('translation.recipient_name') }}</td>
                        <td>{{ __('translation.recipient_phone') }}</td>
                    </tr>

                    <tr class="item">
                        <td>{{ $donation->gift->recipient_name ?? __('translation.null') }}</td>
                        <td>{{ $donation->gift->recipient_phone ?? __('translation.null') }}</td>
                    </tr>
                @elseif ($donation->donation_type === 'beneficiary')
                    <tr class="heading">
                        <td>{{ __('translation.donation') }}</td>

                        <td>{{ __('translation.amount') }}</td>
                    </tr>

                    <tr class="item">
                        <td>{{ $donation->beneficiary->title }}</td>
                        <td>{{ $donation->total_amount . ' ' . __('dashboard.SAR') }}</td>
                    </tr>
                @else
                    <tr class="heading">
                        <td>{{ __('translation.donation') }}</td>

                        <td>{{ __('translation.amount') }}</td>
                    </tr>

                    @foreach ($donation->services as $index => $service)
                        <tr class="item">
                            <td>{{ $service->title }}</td>

                            <td>{{ $service->pivot->amount . ' ' . __('dashboard.SAR') }}</td>
                        </tr>
                    @endforeach
                @endif

				<tr class="total">

					<td>{{ __('dashboard.total_amount') }}: {{ $donation->total_amount . ' ' . __('dashboard.SAR') }}</td>
				</tr>
			</table>
		</div>

            <div class="text-center mt-20">{{ json_decode($donation->response)->rrn ?? __('translation.null') }}</div>

        @auth('donor')
            <div class="text-center mt-20"><a href="{{ route('frontend.profile.show-profile-information', auth('donor')->user()->username) }}">إضغط للعودة إلي ملفك الشخصي</a> <i class="fas fa-arrow-alt-circle-left"></i></div>
        @endauth

        <script src="{{ URL::asset('frontend_files/assets/js/jquery-3.5.1.min.js') }}"></script>
        <!-- template js -->
        <script src="{{ URL::asset('frontend_files/assets/js/jquery-ui.js') }}"></script>
        <script src="{{ URL::asset('frontend_files/assets/js/theme.js') }}"></script>
	</body>
</html>
