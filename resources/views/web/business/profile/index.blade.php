@extends('layout.master')
@section('content')
<div class="contentBody">
    <div class="profileWrap">
        <ul class="nav nav-pills mb-3 row catTabs genTabs profileTabs" role="tablist">
            <li class="nav-item col-4" role="presentation">
                <button class="nav-link active" id="pills-catTab1-tab" data-bs-toggle="pill" data-bs-target="#pills-catTab1" type="button" role="tab" aria-controls="pills-catTab1" aria-selected="true">Profile</button>
            </li>
            <li class="nav-item col-4 profileTabs" role="presentation">
                <button class="nav-link" id="pills-catTab2-tab" data-bs-toggle="pill" data-bs-target="#pills-catTab2" type="button" role="tab" aria-controls="pills-catTab2" aria-selected="false">Change Password</button>
            </li>
            <li class="nav-item col-4 profileTabs" role="presentation">
                <button class="nav-link" id="pills-catTab3-tab" data-bs-toggle="pill" data-bs-target="#pills-catTab3" type="button" role="tab" aria-controls="pills-catTab3" aria-selected="false">Payment Details</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-catTab1" role="tabpanel" aria-labelledby="pills-catTab1-tab">

                <form class="profileForm pt-5" id="update_profile_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type='file' id="imageUpload" name="avatar" accept=".png, .jpg, .jpeg" />
                            <label for="imageUpload" class="xy-center">
                                <img src="{{asset('images/upload.png')}}" alt="img">
                            </label>
                        </div>
                        <div class="avatar-preview">
                             
                            <div id="imagePreview" style="background-image: url({{ auth()->user()->avatar?url('/public').auth()->user()->avatar:asset('images/user.png')}});">
                            </div>
                        </div>
                    </div>

                    <div class="formFields">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                    <input type="text" class="formInput1 formInput2" placeholder="Business Name" id="business_name" name="business_name" value="{{auth()->user()->business_name??''}}">
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/login-icon4.png')}}" alt="img" class="w-100">
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                    <input type="tel" class="formInput1 formInput2" placeholder="Phone Number" id="phone_number" maxlength="17" name="phone_number" value="{{auth()->user()->phone_number??''}}">
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/login-icon7.png')}}" alt="img" class="w-100">
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                    <input type="eamil" class="formInput1 formInput2" placeholder="Email Address" value="{{auth()->user()->email??''}}" readonly>
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/login-icon1.png')}}" alt="img" class="w-100">
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                <input type="text" class="formInput1 formInput2" placeholder="Address" value="{{auth()->user()->address??''}}" class="inputItemMain">
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/address-icon.png')}}" alt="img" class="w-100">
                                    </p>
                                </div>
                            </div>
                            @php
                            $links = json_decode(auth()->user()->social_links)
                            @endphp
                            {{-- 
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                    <input type="url" class="formInput1 formInput2" placeholder="Website" id="website" name="website" value="{{$links->website??''}}">
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/login-icon6.png')}}" alt="img" class="w-100">
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                    <input type="url" class="formInput1 formInput2" id="facebook" name="facebook" placeholder="Facebook" value="{{$links->facebook??''}}">
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/login-icon8.png')}}" alt="img" class="w-100 fbiCon">
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                    <input type="url" class="formInput1 formInput2" id="instagram" name="instagram" placeholder="Instagram" value="{{$links->instagram??''}}">
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/instagram-icon.png')}}" alt="img" class="w-100">
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                    <input type="url" class="formInput1 formInput2" id="twitter" name="twitter" placeholder="Twitter" value="{{$links->twitter??''}}">
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/twitter-icon.png')}}" alt="img" class="w-100">
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group2 relClass">
                                    <input type="url" class="formInput1 formInput2" id="linkedIn" name="linkedIn" placeholder="LinkedIn" value="{{$links->linkedIn??''}}">
                                    <p class="inputIcon absClass xy-center">
                                        <img src="{{asset('images/linkedin-icon.png')}}" alt="img" class="w-100">
                                    </p>
                                </div>
                            </div>
                                --}}
                            {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                                <a href="#!" class="genBtn addMoreBtn2">Add More <img src="{{asset('images/add-icon.png')}}" alt="img" class="ms-2"></a>
                        </div> --}}


                        <div class="col-12">
                            <button type="submit" class="genBtn addnewBtn2" id="update_profile_btn">Update</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>

        <div class="tab-pane fade" id="pills-catTab2" role="tabpanel" aria-labelledby="pills-catTab2-tab">
            <div class="formFields passwordField pt-5">
                <form class="row" id="change_password">
                    <div class="col-12">
                        <div class="form-group2 relClass">
                            <input type="password" class="formInput1 formInput2" name="current_password" id="current_password" placeholder="Current Password">
                            <p class="inputIcon absClass xy-center">
                                <img src="{{asset('images/login-icon2.png')}}" alt="img" class="w-100">
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group2 relClass">
                            <input type="password" class="formInput1 formInput2" placeholder="New Password " name="password" id="new_password">
                            <p class="inputIcon absClass xy-center">
                                <img src="{{asset('images/login-icon2.png')}}" alt="img" class="w-100">
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group2 relClass">
                            <input type="password" class="formInput1 formInput2" placeholder="Confirm Password" name="confirm" id="confirm_password">
                            <p class="inputIcon absClass xy-center">
                                <img src="{{asset('images/login-icon2.png')}}" alt="img" class="w-100">
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="change_password" class="genBtn addnewBtn2">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-catTab3" role="tabpanel" aria-labelledby="pills-catTab3-tab">
            <div class="formFields passwordField pt-5">
                <h1 class="heading pb-4">Enter Details</h1>
                <form class="row">
                    <div class="col-12">
                        <div class="form-group2 relClass">
                            <div class="body">
                                <div class="col-12">
                                    <select class="ddl-select" id="list" name="list">
                                        <option disabled selected>Select Card</option>
                                        <option value="1">Venmo</option>
                                        <option value="2">Zelle</option>
                                        <option value="2">Pay pal</option>
                                        <option value="2">Apple Pay</option>
                                        <option value="2">Wise</option>
                                    </select>
                                </div>
                            </div>
                            <p class="inputIcon absClass xy-center">
                                <img src="{{asset('images/login-icon9.png')}}" alt="img" class="w-100">
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="#!" class="genBtn addnewBtn2">Add</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>

</style>

</div>

@endsection

@section('additional_scripts')
<script>
    $(document).ready(function() {

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

        function isWebsite(url) {
            return valid = /^(ftp|http|https):\/\/[^ "]+$/.test(url);
        }

        function validateFacebookUrl(facebook_url) {
            var pattern = /^(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?$/;
            return pattern.test(facebook_url);
        }

        function validateTwitterUrl(twitter_url) {
            var pattern = /(?:http:\/\/)?(?:www\.)?twitter\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-]*)/;
            return pattern.test(twitter_url);
        }

        function validateLinkedInUrl(linkedIn_url) {
            var pattern = /((https?:\/\/)?((www|\w\w)\.)?linkedin\.com\/)((([\w]{2,3})?)|([^\/]+\/(([\w|\d-&#?=])+\/?){1,}))$/;
            return pattern.test(linkedIn_url);
        }

        function validateInstagramUrl(instagram_url) {
            
            var pattern = /((https?:\/\/)?((www|\w\w)\.)?instagram\.com\/)((([\w]{2,3})?)|([^\/]+\/(([\w|\d-&#?=])+\/?){1,}))$/;
            return pattern.test(instagram_url);
        }
        $(document).on('keydown', function(e) {
				if (e.keyCode == 8 && $('#phone_number').is(":focus") && $('#phone_number').val().length < 4) {
					e.preventDefault();
				}
			});
        $("#phone_number").keypress(function(e) {

            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }

            var curchr = this.value.length;
            var curval = $(this).val();
            if (curchr == 6 && curval.indexOf("(") <= -1) {
                $(this).val("+1 (" + curval.replace("+1 ", "") + ")" + "-");
            } else if (curchr == 6 && curval.indexOf("(") > -1) {
                $(this).val(curval + ")-");
            } else if (curchr == 12 && curval.indexOf(")") > -1) {
                $(this).val(curval + "-");
            } else if (curchr == 9) {
                $(this).val(curval + "-");
                $(this).attr('maxlength', '14');
            }


        });
        $(document).on('submit', '#update_profile_form', function(event) {

            event.preventDefault();
            var business_name = $("#business_name").val()
            var phone_number = $("#phone_number").val()
            var website = $("#website").val()
            var facebook = $("#facebook").val()
            var instagram = $("#instagram").val()
            var twitter = $("#twitter").val()
            var linkedIn = $("#linkedIn").val()
            if (!business_name) {
                not('Business Name field is required', 'error');
                return;
            } else if (!phone_number) {
                not('Phone Number Field is required.', 'error');
                return;
            } 
            // else if (website && !isWebsite(website)) {
            //     not('Please provide a valid website Url.', 'error');
            //     return;
            // } else if (facebook && !validateFacebookUrl(facebook)) {
            //     not('Please provide a valid Facebook Url.', 'error');
            //     return;
            // } else if (instagram && !validateInstagramUrl(instagram)) {

            //     not('Please provide a valid Instagram Url.', 'error');
            //     return;
            // } else if (twitter && !validateTwitterUrl(twitter)) {
            //     not('Please provide a valid Twitter Url.', 'error');
            //     return;
            // } else if (linkedIn) {
            //     if (!validateLinkedInUrl(linkedIn)) {
            //         not('Please provide a valid LinkedIn Url.', 'error');
            //         return;
            //     }
            // }

            $.ajax({
                url: "{{ url('business/update-profile') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {

                        not("Profile updated successfully.", 'success');

                        // window.location.reload()
                    } else {

                    }

                },
                error: function(jqXHR, exception) {
                    let data = JSON.parse(jqXHR.responseText);
                    not(data.message, 'error');
                }
            });
            // return;

        });

        function isStrongPassword(password) {
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
            return regex.test(password);

        }
        $('#change_password').on('submit', function(e) {
            e.preventDefault();
            let current_password = $('#current_password').val();
            let new_password = $('#new_password').val();
            let confirm_password = $('#confirm_password').val();
            if (!current_password) {
                not('Current Password Field is required', 'error')
                return;
            } else if (!new_password) {
                not('New Password Field is required', 'error')
                return;

            } else if (!isStrongPassword(new_password)) {
                not('Password should be of 8 characters long (should contain uppercase, lowercase, number and special character).', 'error');
                return;
            } else if (!confirm_password) {
                not('Confirm Password Field is required', 'error')
                return;

            } else if (new_password !== confirm_password) {
                not('New Password and Confirm Password must be same', 'error');
                return;
            }


            $.ajax({
                url: "{{url('business/update-password')}}",
                data: {
                    new_password,
                    current_password,
                    "_token": "{{ csrf_token() }}",
                },
                method: "POST",
                dataType: 'json',
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {

                        not(response.message, 'success');
                        $('#current_password').val('');
                        $('#new_password').val('');
                        $('#confirm_password').val('');
                        // window.location.reload()
                    } else {

                    }

                },
                error: function(jqXHR, exception) {
                    let data = JSON.parse(jqXHR.responseText);
                    not(data.message, 'error');
                }
            });

        });


    })
</script>

@endsection