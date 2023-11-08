<!DOCTYPE html>
<html>

@include('layout.header')

<body>
    <section class="intial-sec">
        <div class="container-fluid p-0">
            <div class="intial-row xy-center">
                <div class="leftCol xy-center" style="background: url({{asset('images/login-bg-2.jpg')}})">
                    <div class="textBox">
                        <div class="loginLogo text-center marginAuto">
                            <img src="{{asset('images/loginLogo.png')}}" alt="img" class="img-fluid loginLogoImg">
                        </div>
                        <p class="loginHeading text-center">Log-in To Continue</p>

                        <form class="loginFrom mt-4" id="login_form">
                            @csrf
                            <div class="form-group relClass mb-3">
                                <input type="email" placeholder="Email Address" name="email" id="email" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon1.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input id="password" type="password" class="inputItemMain" name="password" value="" placeholder="Password">
                                <label class="showPass"><i class="fas fa-eye toggle-password" id="eyeBtn" toggle="#password-field"></i></label>
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon2.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3 text-end">
                                <a href="{{url('business/forgot-password')}}" class="forgotBtn">Forgot Password?</a>
                            </div>
                            <div class="form-group relClass mt-4">
                                <a href="#!" class="genBtn loginBtn" id="login_btn">Login</a>
                            </div>
                        </form>

                       
                        <p class="routeLink text-center">Don’t have an account? <a href="{{url('business/sign-up')}}">Sign Up</a></p>
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

            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-solid fa-eye-slash");
            });

            let btn = document.querySelector('#eyeBtn');

            let input = document.querySelector('#password');

            btn.addEventListener('click', () => {

                if (input.type === "password") {
                    input.type = "text"
                } else {
                    input.type = "password"


                }
            })
            function isEmail(email) {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }

            $(document).on('click', '#login_btn', function(event) {

                event.preventDefault();
                var email = $("#email").val()
                var password = $("#password").val()

                if (!email) {
                    not('Email address field is required', 'error');
                    return;
                } else if (!isEmail(email)) {
                    not('Please enter valid email address.', 'error');
                    return;
                } else if (!password) {
                    not('Password field is required', 'error');
                    return;
                }
                // else if (!isStrongPassword(password)) {
                // 	not('Password should be of 8 characters long (should contain uppercase, lowercase, number and special character)', 'error');
                // 	return;
                // }
                // ​
                $.post("{{url('business/login')}}", $('#login_form').serialize(), function(response) {
                    if (response.status > 0) {
                        let colour = 'success';
                        if (response.data) {
                            localStorage.setItem('email', response.data.email)
                            localStorage.setItem('type', response.data.type)
                            colour = 'error'
                        }
                        not(response.message, colour);
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