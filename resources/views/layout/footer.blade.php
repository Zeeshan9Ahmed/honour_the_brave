<footer>
</footer>
<!-- BOOTSTRAP 5 -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- BOOTSTRAP 5 -->
<!-- JQUERY  -->
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<!-- JQUERY  -->
{{-- <script src="{{asset('assets/js/Chart.js')}}"></script>
<script src="{{asset('assets/js/utils.js')}}"></script>--}}
<!-- JAVASCRIPT SHEETS -->
<script src="{{asset('assets/js/custom.js')}}"></script> 
<script src="{{asset('assets/js/notifIt.js')}}"></script>

<script>
    // PASSWORD SHOW HIDE
    $(document).ready(function() {

       
        var msg = $('#mSg').val();
        var color = $('#mSg').attr('color');

        if (msg) {
            not(msg, color);
        }
    });

    function not(msg, color) {
        notif({
            msg: "</b>" + msg + " ",
            type: color
        });
    }
    
    
</script>

@yield('additional_scripts')

<!-- JAVASCRIPT SHEETS -->