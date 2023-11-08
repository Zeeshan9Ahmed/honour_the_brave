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
                        <p class="loginHeading text-center">Forgot Password</p>

                        <form class="loginFrom mt-4" id="forgot_password_form">
                            @csrf
                            <div class="form-group relClass mb-3">
                                <input type="email" placeholder="Email Address" name="email" id="email" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon1.png')}}" alt="img" class="w-100">

                                </p>
                            </div>
                            <div class="form-group relClass mt-4">
                                <a  id="forgot_password" class="genBtn loginBtn">Send</a>
                            </div>
                        </form>
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

    <script>
        $(document).ready(function() {
            function isEmail(email) {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }

            $(document).on('click', '#forgot_password', function(event) {

                event.preventDefault();

                email = $("#email").val()
               
                if (!email){
                    not('Email address is required.','error')
                    return;
                }else if (!isEmail(email)) {
                    not('Please enter valid email address.', 'error');
                    return;
                }
                $.post("{{url('business/forgot-password')}}", $('#forgot_password_form').serialize(), function(response) {

                    console.log('response', response)
                    // return;
                    if (response.status > 0) {
                        localStorage.setItem('email', response.data.email)
                        localStorage.setItem('type', response.data.type)
                        not('OTP has been Sent on your Email Address', 'success')
                        window.location.href = response.redirect_url;
                    } else {
                        not(response.message, 'error');
                    }
                }, 'json');
            });


        });
    </script>


</body>

</html>