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
                        <p class="loginHeading text-center">Reset Password</p>

                        <form class="loginFrom mt-4">
                            <div class="form-group relClass mb-3">
                                <input id="new_password" type="password" class="inputItemMain" name="new_password" placeholder="New Password">
                                <label class="showPass"><i class="fas fa-eye toggle-password" id="eyeBtn" toggle="#password-field"></i></label>
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon2.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mb-3">
                                <input id="current_password" type="password" class="inputItemMain" name="current_password" placeholder="Confirm Password">
                                <label class="showPass"><i class="fas fa-eye toggle-password" id="eyeBtn2" toggle="#password-field"></i></label>
                                <p class="inputIcon absClass xy-center">
                                    <img src="{{asset('images/login-icon2.png')}}" alt="img" class="w-100">
                                </p>
                            </div>
                            <div class="form-group relClass mt-4">
                                <button class="genBtn loginBtn" id="change_password">Reset</button>
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
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-solid fa-eye-slash");
            });
            let btn = document.querySelector('#eyeBtn');

            let input = document.querySelector('#new_password');
            let btn2 = document.querySelector('#eyeBtn2');
            let input2 = document.querySelector('#current_password');

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

            function isStrongPassword(password) {
                var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
                return regex.test(password);

            }
            $("#change_password").click(function(event) {
                event.preventDefault();

                let new_password = $('#new_password').val();
                let current_password = $('#current_password').val();
                if (!new_password) {
                    not('New Password Field is required', 'error')
                    return;

                } else if (!isStrongPassword(new_password)) {
                    not('Password should be of 8 characters long (should contain uppercase, lowercase, number and special character).', 'error');
                    return;
                } 
                if (!current_password) {
                    not('Confirm Password field is required.', 'error')
                    return;

                }
                else if (new_password !== current_password) {
                    not('New Password and Confirm Password must be same.', 'error');
                    return;
                }

                let email = localStorage.getItem('email');
                let reference_code = localStorage.getItem('reference_code');
                // console.log(reference_code,email)
                $.ajax({

                    url: "{{url('business/change-password')}}",
                    type: "POST",
                    data: {
                        new_password,
                        email,
                        reference_code,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {

                        if (data.status == 1) {

                            not(data.message, 'success');
                            localStorage.removeItem("email");
                            localStorage.removeItem("type");
                            localStorage.removeItem("reference_code");
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


        });
    </script>


</body>

</html>