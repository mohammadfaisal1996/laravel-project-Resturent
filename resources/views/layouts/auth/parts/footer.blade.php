<!-- Essential javascripts for application to work-->
<script src="{{asset("assets/js/jquery-3.2.1.min.js")}}"></script>
<script src="{{asset("assets/js/popper.min.js")}}"></script>
<script src="{{asset("assets/js/bootstrap.min.js")}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset("assets/js/main.js")}}"></script>
<script src="{{asset("assets/js/custom.js")}}"></script>
<script src="{{asset("assets/js/timepicker.min.js")}}"></script>


<!-- The javascript plugin to display page loading on top-->
<script src="{{asset("assets/js/plugins/pace.min.js")}}"></script>



<!-- Page specific javascripts-->

@hasSection("scripts")
    @yield("scripts")
@endif
