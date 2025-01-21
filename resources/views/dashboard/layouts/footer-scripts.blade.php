<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- Scripts -->
<script src="{{ URL::asset('js/app.js') }}"></script>
<!-- JQuery min js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('dashboard_files/assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('dashboard_files/assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
{{-- <script src="{{URL::asset('dashboard_files/assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script> --}}
<!--Internal Sparkline js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('dashboard_files/assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
{{-- <script src="{{URL::asset('dashboard_files/assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('dashboard_files/assets/plugins/sidebar/sidebar-custom.js')}}"></script> --}}
<!-- Eva-icons js -->
<script src="{{URL::asset('dashboard_files/assets/js/eva-icons.min.js')}}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{URL::asset('dashboard_files/assets/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('dashboard_files/assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('dashboard_files/assets/plugins/side-menu/sidemenu.js')}}"></script>
<!-- summernote js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!--fileinput-->
<script src="{{URL::asset('dashboard_files/assets/plugins/bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{URL::asset('dashboard_files/assets/plugins/bootstrap-fileinput/themes/fas/theme.min.js')}}"></script>
<script>
    $(document).ready(function () {
        //delete
        $('.delete').click(function (e) {
            var that = $(this)
            e.preventDefault();
            var n = new Noty({
                theme: "sunset",
                text: '@lang('dashboard.confirm_delete')',
                type: "info",
                killer: true,
                buttons: [
                    Noty.button("نعم", 'btn btn-danger mr-2', function () {
                        that.closest('form').submit();
                    }),
                    Noty.button("لا", 'btn btn-primary mr-2', function () {
                        n.close();
                    })
                ]
            });
            n.show();
        });
    });
</script>

<script>
    // CheckBox Multiple Delete
    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;
        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }
    }
</script>


