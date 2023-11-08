<!DOCTYPE html>
<html>

@include('layout.header')

<body>

    <section class="intial-sec">
        <div class="container-fluid p-0">
            <div class="intial-row xy-center">
                <div class="leftCol xy-center" style="background: url({{asset('images/login-bg-2.jpg')}})">
                    <div class="textBox">
                        <div class="loginLogo text-center marginAuto mb-5">
                            <img src="{{asset('images/loginLogo.png')}}" alt="img" class="img-fluid loginLogoImg">

                        </div>
                        <p class="loginHeading text-center">Enter OTP</p>

                        <form class="loginFrom mt-4" id="reset-form">
                            @csrf
                            <div method="get" class="digit-group pb-3" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                                <input class="inputItemMain" type="text" id="digit-1" name="digit-1" data-next="digit-2" maxlength="1" placeholder="-">
                                <input class="inputItemMain" type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="1" placeholder="-">
                                <input class="inputItemMain" type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="1" placeholder="-">
                                <input class="inputItemMain" type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="1" placeholder="-">
                                <input class="inputItemMain" type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="1" placeholder="-">
                                <input class="inputItemMain" type="text" id="digit-6" name="digit-6" data-next="digit-7" data-previous="digit-5" maxlength="1" placeholder="-">
                            </div>
                            <div class="timerBox text-center pt-4">
                                <i class="fa-regular fa-clock"></i>
                                <div id="Timer" class="desc text-center mt-2">00:1</div>
                            </div>
                            <div class="form-group relClass mt-4">
                                <a href="#!" id="reset" class="genBtn loginBtn">Reset</a>
                            </div>
                        </form>
                        <button id="resend-btn" class="routeLink text-center xy-center" >Resend Verification Code</button>
                    </div>
                </div>

                <div class="rightCol">
                    <div class="mobileAbs">
                        <img src="{{asset('images/mobile.png')}}" alt="img" class="img-fluid">
                    </div>
                    <img src="{{asset('images/ellipse1.png')}}" alt="img" class="ellipse1 img-fluid">
                    <img src="{{asset('images/ellipse2.png')}}" alt="img" class="ellipse2 img-fluid">
                </div>
            </div>
        </div>
    </section>

    @include('layout.footer')
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script>
        $(document).ready(function() {
            /// OTP TIMER START
            var resendBtn = document.getElementById('resend-btn');
            resendBtn.disabled = true;
            
            var timerId;
            var timeLeft = 30;
            var elem = document.getElementById('Timer');

            timerId = setInterval(countdown, 1000);

            function countdown() {
                if (timeLeft < 0) {
                    clearTimeout(timerId);
                    document.getElementById("resend-btn").disabled = false;
                } else {
                    seconds = timeLeft >= 10 ? timeLeft : `0${timeLeft}`


                    elem.innerHTML = '00:' + seconds;
                    timeLeft--;
                }
            }
            /// OTP TIMER END
            $("#reset").click(function(event) {
                event.preventDefault();
                 

                var otp_form = $('#reset-form').serializeArray();

                for (i = 1; i <= 6; i++) {

                    if (otp_form[i].value == '') {
                        not(" The OTP field can't be empty", 'error')
                        return;
                    }
                }

                // return;
                otp_form.push({
                    name: "email",
                    value: localStorage.getItem('email')
                });
                otp_form.push({
                    name: "type",
                    value: localStorage.getItem('type')
                });
                $.ajax({

                    url: "{{url('business/otp-verify')}}",
                    type: "POST",
                    data: otp_form,
                    success: function(data) {
                        console.log(data, 'data')
                        if (data.status == 1) {

                            localStorage.setItem('reference_code', data.data.reference_code)
                            // return;
                            // not(data.message, 'success');
                            window.location.href = data.redirect_url;
                        } else if (data.status == 0) {
                            not(data.message, 'error');
                        }
                    },
                    error: function(error) {
                        console.log(error, 'dfasf');
                    }
                });
            });


            $("#resend-btn").click(function(event) {

                email = localStorage.getItem('email')
                type = localStorage.getItem('type')
                url = "";
                if (type == "PASSWORD_RESET") {
                    url = "{{url('business/forgot-password')}}";
                } else {
                    url = "{{url('business/resend-otp')}}";
                }
                // console.log(email, type)
                // return;

                $.ajax({

                    url: url,
                    type: "POST",
                    data: {
                        email,
                        "_token": "{{csrf_token()}}"
                    },
                    success: function(data) {

                        if (data.status == 1) {
                            
                 document.getElementById("resend-btn").disabled = true;
                 
                            elem.innerHTML = ""
                            timeLeft = 30;
                            clearTimeout(timerId)
                            timerId = setInterval(countdown, 1000);

                            event.preventDefault();
                            not(data.message, 'success');

                        } else if (data.status == 0) {
                            not(data.message, 'error');
                        }
                    },
                    error: function(error) {
                        console.log(error, 'dfasf');
                    }
                });
            });


        });
    </script>


</body>

</html>