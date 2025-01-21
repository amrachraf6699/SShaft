<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link href="{{ URL::asset('frontend_files/assets/certificate_albir/fonts/Stv.woff') }}" />
        <title>{{ setting()->name . ' » شهادة عضو جمعية عمومية (' . $member->full_name . ')' }}</title>
        <!-- favicons Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
        <!--[if mso]>
        <xml>
            <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
        <style>
            table {border-collapse: collapse;}
            .spacer,.divider {mso-line-height-rule: exactly;}
            td,th,div,p,a {font-size: 13px; line-height: 23px;}
            td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family:"Segoe UI",Helvetica,Arial,sans-serif;}
        </style>
        <![endif]-->

        <style type="text/css">
            @font-face {
            font-family: 'Stv';
            font-style: normal;
            font-weight: 400;
            src: url({{ URL::asset('frontend_files/assets/certificate_albir/fonts/Stv.otf') }});
            }
            table, tbody, td, th{
            direction: rtl;
            background: none;
            }
            @import url({{ URL::asset('frontend_files/assets/certificate_albir/fonts/Stv.woff') }});
            body{
            font-family: 'Stv' !important;
            color: #918674;
            }
            @media only screen {

            .serif {font-family: 'Stv',-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI","Roboto",Helvetica,Arial,sans-serif;}

            }

            a {text-decoration: none;}
            img {border: 0; line-height: 100%; max-width: 100%; vertical-align: middle;}

            .wrapper {min-width: 700px;}
            .row {margin: 0 auto; width: 700px;}
            .row .row, th .row {width: 100%;}
            .column {font-size: 13px; line-height: 23px;}

            @media only screen and (max-width: 699px) {

            .wrapper {min-width: 100% !important;}
            .row {width: 90% !important;}
            .row .row {width: 100% !important;}

            .column {
                box-sizing: border-box;
                display: inline-block !important;
                line-height: inherit !important;
                width: 100% !important;
                word-break: break-word;
                -webkit-text-size-adjust: 100%;
            }
            .half-col{
                width:50% !important;
            }
            .mobile-1  {max-width: 8.33333%;}
            .mobile-2  {max-width: 16.66667%;}
            .mobile-3  {max-width: 25%;}
            .mobile-4  {max-width: 33.33333%;}
            .mobile-5  {max-width: 41.66667%;}
            .mobile-6  {max-width: 50%;}
            .mobile-7  {max-width: 58.33333%;}
            .mobile-8  {max-width: 66.66667%;}
            .mobile-9  {max-width: 75%;}
            .mobile-10 {max-width: 83.33333%;}
            .mobile-11 {max-width: 91.66667%;}
            .mobile-12 {
                padding-right: 30px !important;
                padding-left: 30px !important;
            }

            .mobile-offset-1  {margin-left: 8.33333% !important;}
            .mobile-offset-2  {margin-left: 16.66667% !important;}
            .mobile-offset-3  {margin-left: 25% !important;}
            .mobile-offset-4  {margin-left: 33.33333% !important;}
            .mobile-offset-5  {margin-left: 41.66667% !important;}
            .mobile-offset-6  {margin-left: 50% !important;}
            .mobile-offset-7  {margin-left: 58.33333% !important;}
            .mobile-offset-8  {margin-left: 66.66667% !important;}
            .mobile-offset-9  {margin-left: 75% !important;}
            .mobile-offset-10 {margin-left: 83.33333% !important;}
            .mobile-offset-11 {margin-left: 91.66667% !important;}

            .has-columns {
                padding-right: 20px !important;
                padding-left: 20px !important;
            }

            .has-columns .column {
                padding-right: 10px !important;
                padding-left: 10px !important;
            }

            .mobile-collapsed .column {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .mobile-center {
                display: table !important;
                float: none;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .mobile-left {
                float: none;
                margin: 0 !important;
            }
            .mobile-text-center {text-align: center !important;}
            .mobile-text-left   {text-align: right !important;}
            .mobile-text-right  {text-align: right !important;}

            .mobile-valign-top  {vertical-align: top !important;}

            .mobile-full-width {
                display: table;
                width: 100% !important;
            }

            .spacer                     {height: 30px; line-height: 100% !important; font-size: 100% !important;}
            .divider th                 {height: 60px;}
            .mobile-padding-top         {padding-top: 30px !important;}
            .mobile-padding-top-mini    {padding-top: 10px !important;}
            .mobile-padding-bottom      {padding-bottom: 30px !important;}
            .mobile-padding-bottom-mini {padding-bottom: 10px !important;}
            .mobile-margin-top          {margin-top: 30px !important;}
            .mobile-margin-top-mini     {margin-top: 10px !important;}
            .mobile-margin-bottom       {margin-bottom: 30px !important;}
            .mobile-margin-bottom-mini  {margin-bottom: 10px !important;}
            }
        </style>
    </head>
    <body style="box-sizing:border-box;margin:0;padding:0;width:100%;-webkit-font-smoothing:antialiased;">
        <table class="wrapper" align="center" bgcolor="#EEEEEE" cellpadding="0" cellspacing="0" width="100%" role="presentation">
            <tr>
                <td style="padding: 30px 0;">

                    <!-- Header -->
                    <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <th class="column" width="700">
                                <img src="{{ URL::asset('frontend_files/assets/certificate_albir/images/top-image.png') }}" alt="Full Width Image" width="700">
                            </th>
                        </tr>
                    </table>
                    <!-- /Header -->

                    <!-- Logo -->
                    <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <th class="column" width="50%">
                                <img src="{{ URL::asset('frontend_files/assets/certificate_albir/images/logo.png') }}" alt="Logo" width="60%">
                            </th>
                        </tr>
                    </table>
                    <!-- /Logo -->

                    <!-- Certificate -->
                    <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <th class="column" width="50%">
                                <img src="{{ URL::asset('frontend_files/assets/certificate_albir/images/cert.png') }}" alt="Full Width Image" width="60%">
                            </th>
                        </tr>
                    </table>
                    <!-- /Certificate -->

                    <!-- Content -->
                    <table class="row" align="center" bgcolor="#F8F8F8" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <th class="column has-columns" width="640" style="padding-left: 30px; padding-right: 30px;">
                                <table class="row" align="center" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <th class="column" width="640" style="text-align: right;">
                                            <div class="serif" style="font-size: 22px; font-weight: 400; line-height: 28px; margin-bottom: 15px; margin-top:15px;direction: rtl; text-align: center;">تشهد جمعية البر بجدة أن</div>
                                            <div class="serif" style="font-size: 28px; font-weight: 700; line-height: 50px; margin-bottom: 30px; margin-top: 20px; text-align: center;"> {{ $member->full_name }}</div>
                                            <div class="serif" style="font-size: 22px; font-weight: 400; line-height: 28px; margin-bottom: 15px; margin-top:15px;direction: rtl; text-align: center; width:400px; margin-right: auto; margin-left: auto;">أحد أعضاء الجمعية العمومية لجمعية البر بجدة شاكرين ومقدرين له تعاونه ودعمه المتواصل للجمعية</div>
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </table>

                    <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation" style="background-image: url({{ URL::asset('frontend_files/assets/certificate_albir/images/footer.png') }}); background-size: contain; background-repeat: no-repeat; height: 200px;">
                        <tr class="mobile-valign-top">
                            <th class="column half-col" width="310" style="padding-left: 10px; padding-right: 65px; font-weight: 400; text-align: right; font-size: 10px; vertical-align: top;">
                                <p style="margin-top:20px; margin-bottom: 0;">تنتهي صلاحية الشهادة في </p>
                                <p style="text-align: center; width: 30%; margin-top: 0;">{{ $member->expiry_date }}</p>
                            </th>
                            <th class="column half-col" width="310" style="padding-right: 10px; font-weight: 400;vertical-align: top; font-size: 16px;">
                                <div style="width: 60%; text-align: center;">
                                    رئيس مجلس الإدارة
                                    <br>
                                    <p style="font-weight:bold; margin-top: 26px; font-size: 18px;">سهيل بن حسن قاضي</p>
                                </div>
                            </th>
                        </tr>
                    </table>
                    <!-- ./Content -->
                </td>
            </tr>
        </table>
    </body>
</html>
