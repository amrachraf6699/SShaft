<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ 'تدشين موقع ' . setting()->name }}</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
    <link href="{{ URL::asset('frontend_files/assets/inauguration/fonts/Stv.woff') }}" />
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
        src: url({{ URL::asset('frontend_files/assets/inauguration/fonts/Stv.otf') }});
      }
      table, tbody, td, th{
        direction: rtl;
        background: none;
      }
      @import url({{ URL::asset('frontend_files/assets/inauguration/fonts/Stv.woff') }});
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
      .row {margin: 0 auto; max-width: 1200px; width: 100%;}
      .row .row, th .row {width: 100%;}
      .column {font-size: 13px; line-height: 23px;}
      .btn-box {position: absolute; bottom: 17%; right: 0; left: 0; z-index: 2;}
      .btn-img {height: 50px; 
        animation: blanker 1.5s linear infinite; 
        -o-animation: blanker 1.5s linear infinite; 
        -ms-animation: blanker 1.5s linear infinite; 
        -moz-animation: blanker 1.5s linear infinite; 
        -webkit-animation: blanker 1.5s linear infinite;
      }
      @-webkit-keyframes blanker {
        0% {
          -webkit-transform: scale(1);
        }
        25% {
          -webkit-transform: scale(.85);
        }
        50% {
          -webkit-transform: scale(1);
        }
        75% {
          -webkit-transform: scale(1.15);
        }
        100% {
          -webkit-transform: scale(1);
        }
      }
      @-moz-keyframes blanker {
        0% {
          -moz-transform: scale(1);
        }
        25% {
          -moz-transform: scale(.85);
        }
        50% {
          -moz-transform: scale(1);
        }
        75% {
          -moz-transform: scale(1.15);
        }
        100% {
          -moz-transform: scale(1);
        }
      }
      @-ms-keyframes blanker {
        0% {
          -ms-transform: scale(1);
        }
        25% {
          -ms-transform: scale(.85);
        }
        50% {
          -ms-transform: scale(1);
        }
        75% {
          -ms-transform: scale(1.15);
        }
        100% {
          -ms-transform: scale(1);
        }
      }
      @-o-keyframes blanker {
        0% {
          -o-transform: scale(1);
        }
        25% {
          -o-transform: scale(.85);
        }
        50% {
          -o-transform: scale(1);
        }
        75% {
          -o-transform: scale(1.15);
        }
        100% {
          -o-transform: scale(1);
        }
      }
      @keyframes blanker {
        0% {
          transform: scale(1);
        }
        25% {
          transform: scale(.85);
        }
        50% {
          transform: scale(1);
        }
        75% {
          transform: scale(1.15);
        }
        100% {
          transform: scale(1);
        }
      }
      @media only screen and (max-width: 699px) {

        .wrapper {min-width: 100% !important;}
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
      @media only screen and (max-width: 1200px) {
        .btn-box {bottom: 16%;}
        .btn-img {height: 40px;}
      }
      @media only screen and (max-width: 700px) {
        .btn-box {bottom: 8%;}
        .btn-img {height: 40px;}
      }
      @media only screen and (max-width: 400px) {
        .btn-img {height: 35px;}
      }
      #particles-js {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1;
      }
    </style>
  </head>
  <body style="box-sizing:border-box;margin:0;padding:0;width:100%;-webkit-font-smoothing:antialiased;">

    <table class="wrapper" align="center" bgcolor="#EEEEEE" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="position: relative;">
      <tr>
        <td>

          <!-- Header -->
          <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <div id="particles-js"></div>
            </tr>
            <tr>
              <th class="column">
                <img src="{{ URL::asset('frontend_files/assets/inauguration/images/bg.jpg') }}" width="100%">
              </th>
            </tr>
          </table>
          <!-- /Header -->


          <!-- Footer -->
          <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <th class="column" width="700">
                <p class="btn-box">
                  <a href="{{ route('frontend.home') }}" target="_blank">
                    <img src="{{ URL::asset('frontend_files/assets/inauguration/images/btn.png') }}" class="btn-img">
                  </a>
                </p>
              </th>
            </tr>
          </table>
          <!-- /Footer -->

        </td>
      </tr>
    </table>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="{{ URL::asset('frontend_files/assets/inauguration/js/particles.min.js') }}"></script>
    <script>
      particlesJS('particles-js',

        {
          "particles": {
            "number": {
              "value": 80,
              "density": {
                "enable": true,
                "value_area": 800
              }
            },
            "color": {
              "value": "#ffffff"
            },
            "shape": {
              "type": "circle",
              "stroke": {
                "width": 0,
                "color": "#ffffff"
              },
              "polygon": {
                "nb_sides": 5
              },
              "image": {
                "src": "{{ URL::asset('frontend_files/assets/inauguration/img/github.svg') }}",
                "width": 100,
                "height": 100
              }
            },
            "opacity": {
              "value": 0.5,
              "random": false,
              "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.1,
                "sync": false
              }
            },
            "size": {
              "value": 5,
              "random": true,
              "anim": {
                "enable": false,
                "speed": 40,
                "size_min": 0.1,
                "sync": false
              }
            },
            "line_linked": {
              "enable": true,
              "distance": 150,
              "color": "#ffffff",
              "opacity": 0.4,
              "width": 1
            },
            "move": {
              "enable": true,
              "speed": 6,
              "direction": "none",
              "random": false,
              "straight": false,
              "out_mode": "out",
              "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
              }
            }
          },
          "interactivity": {
            "detect_on": "canvas",
            "events": {
              "onhover": {
                "enable": true,
                "mode": "repulse"
              },
              "onclick": {
                "enable": true,
                "mode": "push"
              },
              "resize": true
            },
            "modes": {
              "grab": {
                "distance": 400,
                "line_linked": {
                  "opacity": 1
                }
              },
              "bubble": {
                "distance": 400,
                "size": 40,
                "duration": 2,
                "opacity": 8,
                "speed": 3
              },
              "repulse": {
                "distance": 200
              },
              "push": {
                "particles_nb": 4
              },
              "remove": {
                "particles_nb": 2
              }
            }
          },
          "retina_detect": true,
          "config_demo": {
            "hide_card": false,
            "background_color": "#f00",
            "background_image": "",
            "background_position": "50% 50%",
            "background_repeat": "no-repeat",
            "background_size": "cover"
          }
        }

      );
  </script>

  </body>
</html>
