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
                        <p class="loginHeading text-center">Create A New Account</p>

                        <form class="loginFrom mt-4" id="sign-up-form">
                            @csrf
                            <div class="form-group relClass mb-3">
                                <input type="text" placeholder="Full Name" id="full_name" name="full_name" class="inputItemMain">
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon3.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input type="email" placeholder="Email Address" id="email" name="email" class="inputItemMain">
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
                            <div class="form-group relClass mb-3">
                                <input id="confirm" type="password" class="inputItemMain" name="confirm" value="" placeholder="Confirm Password">
                                <label class="showPass"><i class="fas fa-eye toggle-password" id="eyeBtn2" toggle="#password-field"></i></label>
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon2.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" >
                                    <label class="form-check-label" for="flexCheckDefault2">
                                        Agree to terms & Conditions
                                    </label>
                                </div>
                            </div>
                            <div class="form-group relClass mt-4">
                                <a href="#!" class="genBtn loginBtn" id="sign-up">Sign Up</a>
                            </div>
                        </form>
                        <p class="routeLink text-center">Already have an account? <a href="{{url('business/login')}}">Login</a></p>
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

            function isStrongPassword(password) {
                var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
                return regex.test(password);

            }
            $(document).on('click', '#sign-up', function(event) {

                event.preventDefault();
                full_name = $('#full_name').val();
                email = $('#email').val();
                password = $('#password').val();
                confirm = $('#confirm').val();

                if (!full_name) {
                    not('Full Name field is required', 'error')
                    return;
                } else if (!email) {
                    not('Email address field is required', 'error');
                    return;
                } else if (!isEmail(email)) {
                    not('Please enter valid email address.', 'error');
                    return;
                } else if (!(password)) {
                    not('Password Field is required.', 'error');
                    return;
                } else if (!isStrongPassword(password)) {
                    not('Password should be of 8 characters long (should contain uppercase, lowercase, number and special character).', 'error');
                    return;
                } else if (!(confirm)) {
                    not('Confirm Password Field is required.', 'error');
                    return;
                } else if (password !== confirm) {
                    not('Password and Confirm Password must be same.', 'error');
                    return;
                } else if ($('input[type=checkbox]:checked').length == 0) {
                    not("Please Accept Terms & Conditions", 'error');
                    return;
                }
                // return;
                $.post("{{url('business/sign-up')}}", $('#sign-up-form').serialize(), function(response) {
                    if (response.status > 0) {
                        console.log(response)
                        not(response.message, 'success');

                        localStorage.setItem('email', response.data.email)
                        localStorage.setItem('type', response.data.type)
                        // return;
                        window.location.href = response.redirect_url;
                    } else {
                        not(response.message, 'error');
                    }
                }, 'json');
            });
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-solid fa-eye-slash");
            });

            let btn = document.querySelector('#eyeBtn');

            let input = document.querySelector('#password');
            let btn2 = document.querySelector('#eyeBtn2');
            let input2 = document.querySelector('#confirm');

            btn.addEventListener('click', () => {

                if (input.type === "password") {
                    input.type = "text"
                } else {
                    input.type = "password"


                }
            })




            btn2.addEventListener('click', () => {
                if (input2.type === "password") {
                    input2.type = "text"
                } else {
                    input2.type = "password"


                }
            })

        });
    </script>


</body>

</html>